<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class DownloadController extends Controller
{
    /**
     * Download a report file
     */
    public function downloadReport(Request $request, $filename)
    {
        // Rate limiting: max 10 downloads per minute per IP
        $key = 'download_report_' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            Log::warning('Rate limit exceeded for report download', [
                'ip' => $request->ip(),
                'filename' => $filename
            ]);
            abort(429, 'Too many download attempts. Please try again later.');
        }
        RateLimiter::hit($key, 60); // 1 minute window

        try {
            // Validate the filename to prevent directory traversal
            if (!preg_match('/^[a-zA-Z0-9._-]+$/', $filename)) {
                Log::warning('Invalid filename attempted for download', [
                    'filename' => $filename,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
                abort(404, 'Invalid filename');
            }

            $filePath = 'assets/reports/' . $filename;
            
            // Check if file exists in storage
            if (!Storage::disk('public')->exists($filePath)) {
                Log::warning('Report file not found for download', [
                    'filename' => $filename,
                    'file_path' => $filePath,
                    'ip' => $request->ip()
                ]);
                abort(404, 'File not found');
            }

            // Get file information
            $file = Storage::disk('public')->path($filePath);
            $mimeType = Storage::disk('public')->mimeType($filePath);
            $fileSize = Storage::disk('public')->size($filePath);

            // Validate file size (max 50MB)
            if ($fileSize > 52428800) {
                Log::warning('File too large for download', [
                    'filename' => $filename,
                    'file_size' => $fileSize,
                    'ip' => $request->ip()
                ]);
                abort(413, 'File too large');
            }

            // Log successful download
            Log::info('Report file downloaded successfully', [
                'filename' => $filename,
                'file_size' => $fileSize,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Set appropriate headers for download
            $headers = [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => $fileSize,
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'DENY',
            ];

            // Return file as download response
            return response()->download($file, $filename, $headers);

        } catch (\Exception $e) {
            Log::error('Error downloading report file', [
                'filename' => $filename,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);
            abort(500, 'Error downloading file');
        }
    }

    /**
     * Download any file from storage with validation
     */
    public function downloadFile(Request $request, $path)
    {
        // Rate limiting: max 20 downloads per minute per IP
        $key = 'download_file_' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 20)) {
            Log::warning('Rate limit exceeded for file download', [
                'ip' => $request->ip(),
                'path' => $path
            ]);
            abort(429, 'Too many download attempts. Please try again later.');
        }
        RateLimiter::hit($key, 60); // 1 minute window

        try {
            // Validate the path to prevent directory traversal
            if (strpos($path, '..') !== false || strpos($path, '/') === 0) {
                Log::warning('Invalid file path attempted for download', [
                    'path' => $path,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
                abort(404, 'Invalid file path');
            }

            // Check if file exists in storage
            if (!Storage::disk('public')->exists($path)) {
                Log::warning('File not found for download', [
                    'path' => $path,
                    'ip' => $request->ip()
                ]);
                abort(404, 'File not found');
            }

            // Get file information
            $file = Storage::disk('public')->path($path);
            $filename = basename($path);
            $mimeType = Storage::disk('public')->mimeType($path);
            $fileSize = Storage::disk('public')->size($path);

            // Validate file size (max 50MB)
            if ($fileSize > 52428800) {
                Log::warning('File too large for download', [
                    'path' => $path,
                    'file_size' => $fileSize,
                    'ip' => $request->ip()
                ]);
                abort(413, 'File too large');
            }

            // Log successful download
            Log::info('File downloaded successfully', [
                'path' => $path,
                'filename' => $filename,
                'file_size' => $fileSize,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Set appropriate headers for download
            $headers = [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => $fileSize,
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'DENY',
            ];

            // Return file as download response
            return response()->download($file, $filename, $headers);

        } catch (\Exception $e) {
            Log::error('Error downloading file', [
                'path' => $path,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);
            abort(500, 'Error downloading file');
        }
    }
} 