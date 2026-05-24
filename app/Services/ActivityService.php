<?php

namespace App\Services ;

use App\Models\ActivityType;

class ActivityService
{
       public function store(array $data)
       {
        $activity=ActivityType::create([

          'name' => [
            'ar'=>$data['name']['ar'],
            'en'=>$data['name']['en']
          ]  ,
        ]);
        return $activity;
       }
       public function update(array $data , $id)
       {
           $activity=ActivityType :: findorfail($id);
           $activity->update([
            'name' => [
              'ar'=>$data['name']['ar'],
              'en'=>$data['name']['en']
            ]  ,
            ]);
            $activity->save();
            return $activity;
       }
       public function delete($id)
       {
             $activity= ActivityType::findorfail($id);

    // تحقق إذا فيه business accounts مرتبطة
    if ($activity->businessAccounts()->exists()) {
      return false; // ممنوع الحذف
  }

             $activity->delete();
             return true;
       }
}
