<?php

namespace App\Http\Controllers;

use App\Models\OrganizationSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrganizationSettingController extends Controller
{
    /**
     * Display organization settings.
     */
    public function edit(): View
    {
        $settings = OrganizationSetting::query()->first()
            ?? new OrganizationSetting([
                'organization_name' => config('app.name', 'Organization'),
                'system_name' => 'Document Management System',
            ]);

        return view('settings.organization', compact('settings'));
    }

    /**
     * Save organization settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_name' => [
                'required',
                'string',
                'max:255',
            ],
            'organization_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'system_name' => [
                'required',
                'string',
                'max:255',
            ],
            'system_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'organization_logo.image' => 'The organization logo must be a valid image.',
            'organization_logo.max' => 'The organization logo must not exceed 2 MB.',
            'system_logo.image' => 'The system logo must be a valid image.',
            'system_logo.max' => 'The system logo must not exceed 2 MB.',
        ]);

        $settings = OrganizationSetting::query()->first()
            ?? new OrganizationSetting();

        $oldOrganizationLogo = $settings->organization_logo;
        $oldSystemLogo = $settings->system_logo;

        // Store uploaded files before updating the database.
        if ($request->hasFile('organization_logo')) {
            $validated['organization_logo'] = $request
                ->file('organization_logo')
                ->store('organization', 'public');
        }

        if ($request->hasFile('system_logo')) {
            $validated['system_logo'] = $request
                ->file('system_logo')
                ->store('organization', 'public');
        }

        $settings->fill($validated);
        $settings->save();

        // Remove replaced files only after the settings have been saved.
        if (
            $request->hasFile('organization_logo')
            && $oldOrganizationLogo
            && $oldOrganizationLogo !== $settings->organization_logo
        ) {
            Storage::disk('public')->delete($oldOrganizationLogo);
        }

        if (
            $request->hasFile('system_logo')
            && $oldSystemLogo
            && $oldSystemLogo !== $settings->system_logo
        ) {
            Storage::disk('public')->delete($oldSystemLogo);
        }

        return redirect()
            ->route('settings.organization.edit')
            ->with('success', 'Organization settings updated successfully.');
    }

    /**
     * Remove the organization logo.
     */
    public function removeOrganizationLogo(): RedirectResponse
    {
        $settings = OrganizationSetting::query()->firstOrFail();

        if ($settings->organization_logo) {
            Storage::disk('public')->delete($settings->organization_logo);

            $settings->organization_logo = null;
            $settings->save();
        }

        return redirect()
            ->route('settings.organization.edit')
            ->with('success', 'Organization logo removed successfully.');
    }

    /**
     * Remove the DMS product logo.
     */
    public function removeSystemLogo(): RedirectResponse
    {
        $settings = OrganizationSetting::query()->firstOrFail();

        if ($settings->system_logo) {
            Storage::disk('public')->delete($settings->system_logo);

            $settings->system_logo = null;
            $settings->save();
        }

        return redirect()
            ->route('settings.organization.edit')
            ->with('success', 'System logo removed successfully.');
    }
}
