<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($section_key)
    {
        $section = HomeSection::where('section_key', $section_key)->firstOrFail();
        $view = 'admin.home_sections.edit_' . $section_key;
        if (!view()->exists($view)) {
            $view = 'admin.home_sections.edit'; // fallback to default
        }
        return view($view, compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $section_key)
    {
        $section = HomeSection::where('section_key', $section_key)->firstOrFail();

        // Custom logic for management section
        if ($section_key === 'management') {
            $members = json_decode($section->content, true) ?? [];

            // Remove member
            if ($request->has('remove_member')) {
                $idx = (int)$request->input('remove_member');
                array_splice($members, $idx, 1);
                $section->content = json_encode(array_values($members));
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Member removed successfully.');
            }

            // Edit member
            if ($request->has('edit_member')) {
                $idx = (int)$request->input('edit_member');
                if (isset($members[$idx])) {
                    $members[$idx]['name'] = $request->input('name');
                    $members[$idx]['role'] = $request->input('role');
                    if ($request->hasFile('photo')) {
                        $photo = $request->file('photo')->store('assets', 'public');
                        $members[$idx]['photo'] = $photo;
                    }
                }
                $section->content = json_encode(array_values($members));
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Member updated successfully.');
            }

            // Add member
            if ($request->has('add_member')) {
                $newMember = [
                    'name' => $request->input('name'),
                    'role' => $request->input('role'),
                    'photo' => null,
                ];
                if ($request->hasFile('photo')) {
                    $photo = $request->file('photo')->store('assets', 'public');
                    $newMember['photo'] = $photo;
                }
                $members[] = $newMember;
                $section->content = json_encode(array_values($members));
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Member added successfully.');
            }
        }

        // Custom logic for activities section
        if ($section_key === 'activities') {
            $activities = json_decode($section->content, true) ?? [];

            // Remove activity
            if ($request->has('remove_activity')) {
                $idx = (int)$request->input('remove_activity');
                array_splice($activities, $idx, 1);
                $section->content = json_encode(array_values($activities));
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Activity removed successfully.');
            }

            // Edit activity
            if ($request->has('edit_activity')) {
                $idx = (int)$request->input('edit_activity');
                if (isset($activities[$idx])) {
                    $activities[$idx]['date'] = $request->input('date');
                    $activities[$idx]['title'] = $request->input('title');
                    $activities[$idx]['description'] = $request->input('description');
                }
                $section->content = json_encode(array_values($activities));
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Activity updated successfully.');
            }

            // Add activity
            if ($request->has('add_activity')) {
                $newActivity = [
                    'date' => $request->input('date'),
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                ];
                $activities[] = $newActivity;
                $section->content = json_encode(array_values($activities));
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Activity added successfully.');
            }
        }

        // Custom logic for reports section
        if ($section_key === 'reports') {
            $reports = json_decode($section->content, true) ?? [];

            // Remove report
            if ($request->has('remove_report')) {
                $idx = (int)$request->input('remove_report');
                if (isset($reports[$idx])) {
                    // Delete associated file if exists
                    if (!empty($reports[$idx]['file']) && Storage::disk('public')->exists($reports[$idx]['file'])) {
                        Storage::disk('public')->delete($reports[$idx]['file']);
                    }
                    array_splice($reports, $idx, 1);
                    $section->content = json_encode(array_values($reports));
                    $section->save();
                    return redirect()->route('admin.home_sections.edit', $section_key)
                        ->with('success', 'Report removed successfully.');
                }
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('error', 'Report not found.');
            }

            // Edit report
            if ($request->has('edit_report')) {
                $request->validate([
                    'year' => 'required|integer',
                    'description' => 'required|string',
                    'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
                ]);

                $idx = (int)$request->input('edit_report');
                if (isset($reports[$idx])) {
                    $reports[$idx]['year'] = $request->input('year');
                    $reports[$idx]['description'] = $request->input('description');
                    
                    if ($request->hasFile('file')) {
                        // Delete old file if exists
                        if (!empty($reports[$idx]['file']) && Storage::disk('public')->exists($reports[$idx]['file'])) {
                            Storage::disk('public')->delete($reports[$idx]['file']);
                        }
                        
                        $file = $request->file('file')->store('assets/reports', 'public');
                        $reports[$idx]['file'] = $file;
                    }
                }
                $section->content = json_encode(array_values($reports));
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Report updated successfully.');
            }

            // Add report
            if ($request->has('add_report')) {
                $request->validate([
                    'year' => 'required|integer',
                    'description' => 'required|string',
                    'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
                ]);

                $newReport = [
                    'year' => $request->input('year'),
                    'description' => $request->input('description'),
                    'file' => null,
                ];
                if ($request->hasFile('file')) {
                    $file = $request->file('file')->store('assets/reports', 'public');
                    $newReport['file'] = $file;
                }
                $reports[] = $newReport;
                $section->content = json_encode(array_values($reports));
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Report added successfully.');
            }
        }

        // Custom logic for support section
        if ($section_key === 'support') {
            $supportData = json_decode($section->content, true) ?? [];
            
            // Handle description update
            if ($request->has('description')) {
                $supportData['description'] = $request->input('description');
                $section->content = json_encode($supportData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Support description updated successfully.');
            }

            // Handle bank cards
            $cards = $supportData['cards'] ?? [];

            // Remove card
            if ($request->has('remove_card')) {
                $idx = (int)$request->input('remove_card');
                array_splice($cards, $idx, 1);
                $supportData['cards'] = array_values($cards);
                $section->content = json_encode($supportData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Bank card removed successfully.');
            }

            // Edit card
            if ($request->has('edit_card')) {
                $idx = (int)$request->input('edit_card');
                if (isset($cards[$idx])) {
                    $cards[$idx]['bank_name'] = $request->input('bank_name');
                    $cards[$idx]['account_name'] = $request->input('account_name');
                    $cards[$idx]['account_number'] = $request->input('account_number');
                    $cards[$idx]['branch_code'] = $request->input('branch_code');
                    $cards[$idx]['swift_code'] = $request->input('swift_code');
                }
                $supportData['cards'] = array_values($cards);
                $section->content = json_encode($supportData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Bank card updated successfully.');
            }

            // Add card
            if ($request->has('add_card')) {
                $request->validate([
                    'bank_name' => 'required|string|max:255',
                    'account_name' => 'required|string|max:255',
                    'account_number' => 'required|string|max:255',
                    'branch_code' => 'required|string|max:255',
                    'swift_code' => 'required|string|max:255',
                ]);

                $newCard = [
                    'bank_name' => $request->input('bank_name'),
                    'account_name' => $request->input('account_name'),
                    'account_number' => $request->input('account_number'),
                    'branch_code' => $request->input('branch_code'),
                    'swift_code' => $request->input('swift_code'),
                ];
                $cards[] = $newCard;
                $supportData['cards'] = array_values($cards);
                $section->content = json_encode($supportData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Bank card added successfully.');
            }
        }

        // Custom logic for contact section
        if ($section_key === 'contact') {
            $contactData = json_decode($section->content, true) ?? [];
            
            // Handle description update
            if ($request->has('description')) {
                $contactData['description'] = $request->input('description');
                $section->content = json_encode($contactData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Contact description updated successfully.');
            }

            // Handle contact cards
            $contacts = $contactData['contacts'] ?? [];

            // Remove contact
            if ($request->has('remove_card')) {
                $idx = (int)$request->input('remove_card');
                array_splice($contacts, $idx, 1);
                $contactData['contacts'] = array_values($contacts);
                $section->content = json_encode($contactData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Contact removed successfully.');
            }

            // Edit contact
            if ($request->has('edit_card')) {
                $idx = (int)$request->input('edit_card');
                if (isset($contacts[$idx])) {
                    $contacts[$idx]['name'] = $request->input('name');
                    $contacts[$idx]['role'] = $request->input('role');
                    $contacts[$idx]['phone'] = $request->input('phone');
                    $contacts[$idx]['emails'] = $request->input('emails');
                }
                $contactData['contacts'] = array_values($contacts);
                $section->content = json_encode($contactData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Contact updated successfully.');
            }

            // Add contact
            if ($request->has('add_card')) {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'role' => 'required|string|max:255',
                    'phone' => 'required|string|max:255',
                    'emails' => 'required|string|max:500',
                ]);

                $newContact = [
                    'name' => $request->input('name'),
                    'role' => $request->input('role'),
                    'phone' => $request->input('phone'),
                    'emails' => $request->input('emails'),
                ];
                $contacts[] = $newContact;
                $contactData['contacts'] = array_values($contacts);
                $section->content = json_encode($contactData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Contact added successfully.');
            }
        }

        // Custom logic for locations section
        if ($section_key === 'locations') {
            $locationData = json_decode($section->content, true) ?? [];
            
            // Handle location cards first (add, edit, remove)
            $timorIndonesia = $locationData['timor_indonesia'] ?? [];
            $timorLeste = $locationData['timor_leste'] ?? [];

            // Add location
            if ($request->has('add_location')) {
                $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'required|string',
                    'region' => 'required|in:indonesia,leste'
                ]);

                $newLocation = [
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                ];

                if ($request->input('region') === 'indonesia') {
                    $timorIndonesia[] = $newLocation;
                    $locationData['timor_indonesia'] = array_values($timorIndonesia);
                } else {
                    $timorLeste[] = $newLocation;
                    $locationData['timor_leste'] = array_values($timorLeste);
                }
                
                $section->content = json_encode($locationData);
                $section->save();
                
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Location added successfully.');
            }

            // Edit location
            if ($request->has('edit_location')) {
                $region = $request->input('region');
                $idx = (int)$request->input('idx');
                
                if ($region === 'indonesia' && isset($timorIndonesia[$idx])) {
                    $timorIndonesia[$idx]['title'] = $request->input('title');
                    $timorIndonesia[$idx]['description'] = $request->input('description');
                    $locationData['timor_indonesia'] = array_values($timorIndonesia);
                } elseif ($region === 'leste' && isset($timorLeste[$idx])) {
                    $timorLeste[$idx]['title'] = $request->input('title');
                    $timorLeste[$idx]['description'] = $request->input('description');
                    $locationData['timor_leste'] = array_values($timorLeste);
                }
                
                $section->content = json_encode($locationData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Location updated successfully.');
            }

            // Remove location
            if ($request->has('remove_location')) {
                $region = $request->input('region');
                $idx = (int)$request->input('idx');
                
                if ($region === 'indonesia' && isset($timorIndonesia[$idx])) {
                    array_splice($timorIndonesia, $idx, 1);
                    $locationData['timor_indonesia'] = array_values($timorIndonesia);
                } elseif ($region === 'leste' && isset($timorLeste[$idx])) {
                    array_splice($timorLeste, $idx, 1);
                    $locationData['timor_leste'] = array_values($timorLeste);
                }
                
                $section->content = json_encode($locationData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Location removed successfully.');
            }
            
            // Handle description update (only if no other location operations)
            if ($request->has('description') && !$request->has('add_location') && !$request->has('edit_location') && !$request->has('remove_location')) {
                $locationData['description'] = $request->input('description');
                $section->content = json_encode($locationData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Location description updated successfully.');
            }

            // Handle map image upload
            if ($request->hasFile('map_image')) {
                $request->validate([
                    'map_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
                ]);

                // Delete old image if exists
                if (isset($locationData['map_image']) && Storage::exists($locationData['map_image'])) {
                    Storage::delete($locationData['map_image']);
                }

                $mapPath = $request->file('map_image')->store('locations', 'public');
                $locationData['map_image'] = $mapPath;
                $section->content = json_encode($locationData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Map image updated successfully.');
            }

            // Handle map image removal
            if ($request->has('remove_map_image')) {
                // Delete the image file if it exists
                if (isset($locationData['map_image']) && Storage::exists($locationData['map_image'])) {
                    Storage::delete($locationData['map_image']);
                }
                
                // Remove the map image reference from the data
                $locationData['map_image'] = null;
                $section->content = json_encode($locationData);
                $section->save();
                return redirect()->route('admin.home_sections.edit', $section_key)
                    ->with('success', 'Map image removed successfully.');
            }


        }

        // Default: simple content update
        $request->validate([
            'content' => 'required|string',
        ]);
        $section->content = $request->input('content');
        $section->save();
        return redirect()->route('admin.home_sections.edit', $section_key)
            ->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
