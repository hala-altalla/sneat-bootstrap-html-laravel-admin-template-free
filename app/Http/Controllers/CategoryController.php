<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeCategoryRequest;
use App\Http\Requests\StoreDynamicFieldsRequest;
use App\Http\Requests\storeSubCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Models\DynamicField;
use App\Models\SubCategory;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

  protected $categoryservice ;
  public function __construct(CategoryService $categoryService)
  {
    $this->categoryservice = $categoryService ;
  }
  public function showcategory()
  {
    return view('admin.showcategory');
  }
  public function addcategory()
  {
    return view('admin.addcategory');
  }
  public function addsubcategory(Category $category)
  {
    $subcategories=SubCategory::latest()->get();
    return view('admin.addsubcategory',compact('subcategories','category'));
  }

public function store(storeCategoryRequest $storeCategoryRequest)
{
   $this->categoryservice->store($storeCategoryRequest->validated());
   return redirect()->back();
}
public function view()
{
   $categories=Category::latest()->get();
   return view('admin.addcategory' , compact('categories'));
}
public function index()
{
   $categories=Category::latest()->get();
   return view('admin.showcategory' , compact('categories'));
}
public  function storesubcategory(storeSubCategoryRequest $storeSubCategoryRequest , Category $category)
{
  $this->categoryservice->storesubcategory($storeSubCategoryRequest->validated() , $category);
   return redirect()->back();
}
public function pageeditcategory(Category $category)
{
  $category->with('subcategories')->get();
  return view('admin.updatecategory',compact('category'));
}
public function updatecategory(UpdateCategoryRequest $updateCategoryRequest , $category)
{
  $this->categoryservice->updatecategory($updateCategoryRequest->validated(),$category);
  return redirect()->route('index.category');
}
public function deletecategory($id)
{
  $result = $this->categoryservice->deletecategory($id);

    if ($result == 'both') {
        return back()->with('error', __('messages.faielddelcatsersub'));
    }

    if ($result == 'subcategories') {
        return back()->with('error', __('messages.faielddeletecat'));
    }

    if ($result == 'services') {
        return back()->with('error', __('messages.faielddeleteser'));

    }

    if ($result == 'dynamic') {

      return back()->with('error', __('messages.faielddeletedyn'));

  }


    return back()->with('success', __('messages.successdeletecat'));
}

public function pageupdatesubcategory(SubCategory $subcategory)
{
  return view('admin.updatesubcategory', compact('subcategory'));
}
public function updatesubcategory(UpdateSubCategoryRequest $updateSubCategoryRequest , $sub)
{
      $subcategory=SubCategory::findorfail($sub);
      $subcategory->with('category')->get();
      $this->categoryservice->updatesubcategory($updateSubCategoryRequest->validated(),$sub);
      return redirect()->route('pageeditcategory', $subcategory->category->id );

}
public function deletesubcategory($sub)
{
 $deleted= $this->categoryservice->deletesubcategory($sub);
 if ($deleted == 'both') {
  return back()->with('error', __('messages.faielddelsubdynser'));
}
  if ($deleted=='services') {
    return back()->with('error', __('messages.faielddeletesub'));
}
if ($deleted == 'dynamic') {
  return back()->with('error', __('messages.faielddeletesubdyn'));

}
return back()->with('success',  __('messages.succesdeletesub'));
}
public function pagedynamicfiled()
{
  $categories=Category::with('subcategories')->get();
  $subcategories=SubCategory::all();
  $dynamicfileds=DynamicField::all();
  return view('admin.dynamicfiled' , compact('categories','subcategories','dynamicfileds'));
}
public function  storedynamicfiled(StoreDynamicFieldsRequest $storeDynamicFieldsRequest )
{

 $this->categoryservice->storedynamicfiled($storeDynamicFieldsRequest->validated());
 return redirect()->route('viewdynamicfields');

}
public function viewdynamicfields()
{
  $fields=DynamicField::with('category','subcategory')->latest()->get();
  return view('admin.viewdynamicfield',compact('fields'));
}

public function vieweditdynamic($id)
{
    $field = DynamicField::with('options')->findOrFail($id);
    $categories = Category::with('subcategories')->get();

    return view('admin.dynamic_fields_edit', compact('field', 'categories'));
}
public function updatedynamicfield(Request $request, $id)
{
    $field = DynamicField::findOrFail($id);

    // 1️ تحديث البيانات الأساسية
    $field->update([
        'category_id' => $request->category_id,
        'sub_category_id' => $request->subcategory_id,
        'name' => [
            'ar' => $request->name['ar'] ?? '',
            'en' => $request->name['en'] ?? '',
        ],
        'type' => $request->type,
        'is_required' => $request->is_required ?? false,
    ]);

    // 2 التعامل مع الخيارات
    if ($request->type === 'select') {

        // امسح القديم الخاص بهذا الحقل فقط
        $field->options()->delete();

        // أضف الجديد
        if ($request->filled('options')) {

            foreach ($request->options as $option) {

                $field->options()->create([
                    'value' => [
                        'ar' => $option['ar'] ?? '',
                        'en' => $option['en'] ?? '',
                    ]
                ]);
            }
        }

    } else {
        // إذا مو select → امسح الخيارات
        $field->options()->delete();
    }

    return redirect()->route('viewdynamicfields');
}
public function destroyfield($id)
{
  $field = DynamicField::findOrFail($id);

    //  1. حذف قيم المستخدمين (DynamicFieldValue)
    $field->values()->delete();

    //  2. حذف الخيارات (لو select أو غيره)
    $field->options()->delete();

    //  3. حذف الحقل نفسه
    $field->delete();

    return redirect()->route('viewdynamicfields')
        ->with('success', 'Field deleted successfully');
}
public function getdynamicfields($id)
{
  $category=Category::findorfail($id);
  $categories=Category::all();
  $subcategories=SubCategory::all();
  $dynamicfields=DynamicField::with('category','subcategory')->where('category_id' , $category->id)->get();
  return view('admin.dynamicCategory',compact('dynamicfields','categories','subcategories'));
}
}