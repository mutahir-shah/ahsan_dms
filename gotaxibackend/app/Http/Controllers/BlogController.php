<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogImage;
use App\BlogTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::with('translations')->get();

        return view('admin.blogs.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blogs.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Fetch the languages dynamically
        $languages = getLanguages();

        // Store the picture
        $imagePath = null;
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('blog_images', 'public');
        }

        $blog = Blog::create([
            'image' => $imagePath,
        ]);

        // Loop through each language and store the blog data
        foreach ($languages as $language) {
            $titleKey = 'title_' . $language->id;
            $descriptionKey = 'description_' . $language->id;

            // Check if title and description are present and not empty
            $title = $request->input($titleKey);
            $description = $request->input($descriptionKey);

            if (!empty($title) && !empty($description)) {
                $blog = BlogTranslation::create([
                    'blog_id' => $blog->id,
                    'language_id' => $language->id,
                    'title' => $title,
                    'description' => $description,
                ]);
            }
        }
        return redirect()->route('admin.blogs.index')->with('flash_success', translateKeyword('Blog created successfully.'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return $id;
        $blog = Blog::where('id', $id)->with('translations')->first();

        return view('admin.blogs.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Fetch the blog with its translations
        $blog = Blog::with('translations')->findOrFail($id);

        // Handle the image upload
        if ($request->hasFile('picture')) {
            // Delete old image if it exists
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }

            // Store new image
            $imagePath = $request->file('picture')->store('blog_images', 'public');
            $blog->image = $imagePath;
            $blog->save();
        }

        // Fetch the languages dynamically
        $languages = getLanguages();

        // Loop through each language and update the blog translations
        foreach ($languages as $language) {
            $titleKey = 'title_' . $language->id;
            $descriptionKey = 'description_' . $language->id;

            // Check if title and description are present and not empty
            $title = $request->input($titleKey);
            $description = $request->input($descriptionKey);

            if (!empty($title) && !empty($description)) {
                $translation = $blog->translations->where('language_id', $language->id)->first();
                if ($translation) {
                    // Update existing translation
                    $translation->title = $title;
                    $translation->description = $description;
                    $translation->save();
                } else {
                    // Create new translation
                    BlogTranslation::create([
                        'blog_id' => $blog->id,
                        'language_id' => $language->id,
                        'title' => $title,
                        'description' => $description,
                    ]);
                }
            }
        }

        return redirect()->route('admin.blogs.index')->with('flash_success', translateKeyword('Blog updated successfully.'));
    }

    public function makeFeatured($id)
    {
        // Remove the featured status from any currently featured blog
        Blog::where('is_featured', 1)->update(['is_featured' => 0]);

        // Set the featured status for the specified blog
        $blog = Blog::findOrFail($id);
        $blog->is_featured = 1;
        $blog->save();

        return redirect()->route('admin.blogs.index')->with('flash_success', translateKeyword('Blog marked as featured'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the blog by its ID
        $blog = Blog::findOrFail($id);

        // Delete associated images if they exist
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        // Delete associated translations
        $blog->translations()->delete();

        // Delete the blog itself
        $blog->delete();

        // Redirect back with a success message
        return redirect()->route('admin.blogs.index')->with('flash_success', translateKeyword('Blog deleted successfully.'));
    }
}
