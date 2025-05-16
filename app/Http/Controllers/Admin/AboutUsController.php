<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrustedBrand;
use App\Models\FileManager;
use App\Models\Setting;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AboutUsController extends Controller
{
    public function galleryArea()
    {
        $data['pageTitle'] = 'Gallery Area';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subGalleryAreaActiveClass'] = 'active';
        $data['trustedBrands'] = TrustedBrand::all();

        return view('admin.setting.about.gallery-area')->with($data);
    }

    public function galleryAreaUpdate(Request $request)
    {
        $request->validate([
            'top_area_title' => 'required|max:255',
            'top_area_subtitle' => 'required',
            'trusted_brands.logo.*' => 'mimes:jpg,png,jpeg,webp,gif',
        ]);

        $inputs = Arr::except($request->all(), ['_token', 'trusted_brands']);
        $keys = [];

        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }

        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);

            if ($request->hasFile('gallery_first_image') && $key == 'gallery_first_image') {
                $request->validate([
                    'gallery_first_image' => 'mimes:jpg,png,jpeg,webp,gif'
                ]);

                $upload = settingImageStoreUpdate($option->id, $request->gallery_first_image);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('gallery_second_image') && $key == 'gallery_second_image') {
                $request->validate([
                    'gallery_second_image' => 'mimes:jpg,png,jpeg,webp,gif'
                ]);

                $upload = settingImageStoreUpdate($option->id, $request->gallery_second_image);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('gallery_third_image') && $key == 'gallery_third_image') {
                $request->validate([
                    'gallery_third_image' => 'mimes:jpg,png,jpeg,webp,gif'
                ]);

                $upload = settingImageStoreUpdate($option->id, $request->gallery_third_image);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('gallery_fourth_image') && $key == 'gallery_fourth_image') {
                $request->validate([
                    'gallery_fourth_image' => 'mimes:jpg,png,jpeg,webp,gif'
                ]);

                $upload = settingImageStoreUpdate($option->id, $request->gallery_fourth_image);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } elseif ($request->hasFile('about_us_image') && $key == 'about_us_image') {
                $request->validate([
                    'about_us_image' => 'mimes:jpg,png,jpeg,webp,gif'
                ]);

                $upload = settingImageStoreUpdate($option->id, $request->about_us_image);
                $option->option_value = $upload;
                $option->type = 2;
                $option->save();
            } else {
                $option->option_value = $value;
                $option->type = 1;
                $option->save();
            }
        }

        $now = now();
        if ($request['trusted_brands']) {
            if (count(@$request['trusted_brands']) > 0) {
                foreach ($request['trusted_brands'] as $about_us_brand) {
                    if ($about_us_brand['name'] || @$about_us_brand['logo']) {
                        if (@$about_us_brand['id']) {
                            $point = TrustedBrand::find($about_us_brand['id']);
                        } else {
                            $point = new TrustedBrand();
                        }
                        $point->updated_at = $now;
                        $point->title = @$about_us_brand['name'];
                        $point->save();

                        /*File Manager Call upload*/
                        if (@$about_us_brand['id']) {
                            if (@$about_us_brand['logo']) {
                                $new_file = FileManager::where('origin_type', 'App\Models\TrustedBrand')->where('origin_id', $point->id)->first();
                                if ($new_file) {
                                    $new_file->removeFile();
                                    $upload = $new_file->upload('TrustedBrand', $about_us_brand['logo'], null, $new_file->id);
                                } else {
                                    $new_file = new FileManager();
                                    $upload = $new_file->upload('TrustedBrand', $about_us_brand['logo']);
                                }
                                if ($upload['status']) {
                                    $point->image = $upload['file']->id;
                                    $point->save();
                                }
                            }
                        } else {
                            if (@$about_us_brand['logo']) {
                                $new_file = new FileManager();
                                $upload = $new_file->upload('TrustedBrand', $about_us_brand['logo']);

                                if ($upload['status']) {
                                    $point->image = $upload['file']->id;
                                    $point->save();
                                }
                            }
                        }
                        /* End */
                    }
                }
            }
        }

        TrustedBrand::where('updated_at', '!=', $now)->get()->map(function ($q) {
            $file = FileManager::where('origin_type', 'App\Models\TrustedBrand')->where('origin_id', $q->id)->first();
            if ($file) {
                $file->removeFile();
                $file->delete();
            }
            $q->delete();
        });

        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function teamMember()
    {
        $data['pageTitle'] = 'Team Member';
        $data['navFrontendSettingsActiveClass'] = 'active';
        $data['subTeamMemberActiveClass'] = 'active';
        $data['teamMembers'] = TeamMember::all();

        return view('admin.setting.about.team-member', $data);
    }

    public function teamMemberUpdate(Request $request)
    {
        $request->validate([
            'team_member_title' => 'required|max:255',
            'team_member_subtitle' => 'required'
        ]);

        /*Setting Create or Update*/
        $inputs = Arr::except($request->all(), ['_token', 'team_members']);
        $keys = [];

        foreach ($inputs as $k => $v) {
            $keys[$k] = $k;
        }

        foreach ($inputs as $key => $value) {
            $option = Setting::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->type = 1;
            $option->save();
        }
        /*End*/

        $now = now();
        if ($request['team_members']) {
            if (count(@$request['team_members']) > 0) {
                foreach ($request['team_members'] as $team_member) {
                    if ($team_member['name'] && $team_member['designation'] || @$team_member['image']) {
                        if (@$team_member['id']) {
                            $team = TeamMember::find($team_member['id']);
                        } else {
                            $team = new TeamMember();
                        }
                        $team->updated_at = $now;
                        $team->name = @$team_member['name'];
                        $team->designation = @$team_member['designation'];
                        $team->save();

                        /*File Manager Call upload*/
                        if (@$team_member['id']) {
                            if (@$team_member['image']) {
                                $new_file = FileManager::where('origin_type', 'App\Models\TeamMember')->where('origin_id', $team->id)->first();
                                if ($new_file) {
                                    $new_file->removeFile();
                                    $upload = $new_file->upload('TeamMember', $team_member['image'], null, $new_file->id);
                                } else {
                                    $new_file = new FileManager();
                                    $upload = $new_file->upload('TeamMember', $team_member['image']);
                                }
                                if ($upload['status']) {
                                    $upload['file']->origin_id = $team->id;
                                    $upload['file']->origin_type = "App\Models\TeamMember";
                                    $upload['file']->save();
                                }
                            }
                        } else {
                            if (@$team_member['image']) {
                                $new_file = new FileManager();
                                $upload = $new_file->upload('TeamMember', $team_member['image']);
                                if ($upload['status']) {
                                    $upload['file']->origin_id = $team->id;
                                    $upload['file']->origin_type = "App\Models\TeamMember";
                                    $upload['file']->save();
                                }
                            }
                        }
                        /* End */
                    }
                }
            }
        }

        TeamMember::where('updated_at', '!=', $now)->get()->map(function ($q) {
            $file = FileManager::where('origin_type', 'App\Models\TeamMember')->where('origin_id', $q->id)->first();
            if ($file) {
                $file->removeFile();
                $file->delete();
            }
            $q->delete();
        });

        return redirect()->back()->with('success', __('Updated Successfully'));
    }
}
