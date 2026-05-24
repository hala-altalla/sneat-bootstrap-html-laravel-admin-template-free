<?php

namespace App\Services ;
use App\Models\Admin;
use App\Models\Category;
use App\Models\DynamicField;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class CategoryService
{
  public function store(array $data)
  {
       $category= Category::create([
        'name' => [
          'ar'=>$data['name']['ar'],
          'en'=>$data['name']['en']
        ]
       ]);
  }
  public function storesubcategory(array $data , Category $category)
  {
    $subcategory =SubCategory::create([
      'name' => [
        'ar'=>$data['name']['ar'],
        'en'=>$data['name']['en']
      ]  ,
      'category_id'=>$category->id

      ]);
  }
public function updatecategory(array $data , $categoryid)
{
  $category=Category::findorfail($categoryid);
  $category->update([
    'name' => [
      'ar'=>$data['name']['ar'],
      'en'=>$data['name']['en']
    ]  ,
    ]);
    $category->save();
    return $category;


}
public function deletecategory($id)
{
  $category = Category::findOrFail($id);
  $hasSubcategories = $category->subcategories()->exists();
  $hasdynamicfields = $category->dynamicfields()->exists();

  $hasServices = $category->services()->exists();

  // 1️ إذا الاثنين موجودين
  if ($hasSubcategories && $hasServices) {
      return 'both';
  }

  // 2️ إذا subcategories فقط
  if ($hasSubcategories) {
      return 'subcategories';
  }

  // 3️إذا services فقط
  if ($hasServices) {
      return 'services';
  }
  if ($hasdynamicfields) {
    return 'dynamic';
}
  // 4️⃣ إذا فاضي
  $category->delete();
  return 'deleted';
}

public function updatesubcategory(array $data , $sub)
{
  $subcategory=SubCategory::findorfail($sub);
  $subcategory->update([
    'name' => [
      'ar'=>$data['name']['ar'],
      'en'=>$data['name']['en']
    ]
  ]);
  $subcategory->save();
  return $subcategory;
}
public function deletesubcategory($sub)
{

  $subcategory=SubCategory::findorfail($sub);
  $hasdynamicfields = $subcategory->dynamicfields()->exists();
  $hasservices=$subcategory->services()->exists();

  if($hasdynamicfields && $hasservices)
  {
    return 'both';
  }

  if ($hasdynamicfields)
   {
    return 'dynamic';
  }

  if ($hasservices) {
    return 'services';
}

$subcategory->delete();
return 'deleted';
}
public function storedynamicfiled(array $data)
{
  $field=DynamicField::create([
      'category_id'=>$data['category_id'],
      'sub_category_id'=>$data['subcategory_id'],
      'name' => [
        'ar'=>$data['name']['ar'],
        'en'=>$data['name']['en']
      ],
      'type' => $data['type'],
      'is_required' => $data['is_required'] ?? false,
  ]);

  // إذا Select → نخزن القيم
  if ($data['type'] === 'select') {
      foreach ($data['options'] as $option) {
          $field->options()->create([

              'value' =>[
                'ar'=>$option['ar'],
                'en'=>$option['en']
              ]
          ]);
      }
  }

  return $field;
}


}