<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductStock;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Auth;
use Storage;

//class ProductsImport implements ToModel, WithHeadingRow, WithValidation
class ProductsImport implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
    private $rows = 0;
    
    public function collection(Collection $rows) {
        $canImport = true;
        if (addon_is_activated('seller_subscription')){
            if(Auth::user()->user_type == 'seller' && Auth::user()->seller->seller_package && (count($rows) + Auth::user()->seller->user->products()->count()) > Auth::user()->seller->seller_package->product_upload_limit) {
                $canImport = false;
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
            }
        }
        
        if($canImport) {
            foreach ($rows as $row) {
				$approved = 1;
				if(Auth::user()->user_type == 'seller' && get_setting('product_approve_by_admin') == 1) {
					$approved = 0;
				}
				
                $productId = Product::create([
                            'name' => $row['name_en'],
                            'description' => $row['description_en'],
                            'added_by' => Auth::user()->user_type == 'seller' ? 'seller' : 'admin',
                            'user_id' => Auth::user()->user_type == 'seller' ? Auth::user()->id : User::where('user_type', 'admin')->first()->id,
                            'approved' => $approved,
							'category_id' => $row['category_id'],
                            'brand_id' => $row['brand_id'],
                            'video_provider' => $row['video_provider'],
                            'video_link' => $row['video_link'],
                            'unit_price' => $row['unit_price'],
                            'purchase_price' => $row['purchase_price'] == null ? $row['unit_price'] : $row['purchase_price'],
                            'unit' => $row['unit'],
                            'meta_title' => $row['meta_title'],
                            'meta_description' => $row['meta_description'],
                            'colors' => json_encode(array()),
                            'choice_options' => json_encode(array()),
                            'variations' => json_encode(array()),
                            'slug' => preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($row['slug']))) . '-' . Str::random(5),
                            'thumbnail_img' => $this->downloadThumbnail($row['thumbnail_img']),
                            'photos' => $this->downloadGalleryImages($row['photos']),
                ]);

                ProductTranslation::create([
                    'name' => $row['name_en'],
                    'description' => $row['description_en'],
                    'unit'=>  $row['unit'],
                    'product_id' => $productId->id,
                    'lang' => 'en'

                ]);

                ProductTranslation::create([
                    'name' => $row['name_ar'],
                    'description' => $row['description_ar'],
                    'unit'=> $row['unit'],
                    'product_id' => $productId->id,
                    'lang' => 'sa'

                ]);

     

                ProductStock::create([
                    'product_id' => $productId->id,
                    'qty' => $row['current_stock'],
                    'price' => $row['unit_price'],
                    'variant' => '',
                ]);
            }
            
            flash(translate('Products imported successfully'))->success();
        }
        
        
    }
    
    public function model(array $row)
    {
        ++$this->rows;
    }
    
    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function rules(): array
    {
        return [
             // Can also use callback validation rules
            
        ];
    }

    public function downloadThumbnail($url){
        try {
            $upload = new Upload;
            $upload->external_link = $url;
            $upload->save();

            return $upload->id;
        } catch (\Exception $e) {
            
        }
        return null;
    }

    public function downloadGalleryImages($urls){
        $data = array();
        foreach(explode(',', str_replace(' ', '', $urls)) as $url){
            $data[] = $this->downloadThumbnail($url);
        }
        return implode(',', $data);
    }


}
