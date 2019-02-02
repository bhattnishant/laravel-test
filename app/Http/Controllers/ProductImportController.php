<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravie\Parser\Xml\Reader;
use Laravie\Parser\Xml\Document;
use Illuminate\Support\Facades\DB;


class ProductImportController extends Controller
{
	//@default method initiated inside route
    public function home()
	{		
	
		$xml = (new Reader(new Document()))->load('data/all_products.xml');		
		
		//List of elements need to read from xml
		$productElementsData = 'name,type,size,color,sku,weight,is_in_stock,qty,price,description';
		$productElementsDataImages = 'image1,image2,image3,image4,image5,image6,image7,image8,image9,image10,image11,image12';		
		$productElements = $productElementsData.','.$productElementsDataImages;
		
		//parse xml fields data
		$productsData = $xml->parse(['products' => ['uses' => 'channel.product['.$productElements.']']]);
		
		if(!empty($productsData))
		{
			
			$commmit = 0;
			//Transaction Begin
			DB::beginTransaction();			
			try 
			{						
				//Used single query to get attributes, the data key will be use in product table
				$attribute_data = \App\Attribute::all()->toArray();			
				
				//Used single query to get stock status, the data key will be use in product table			
				$stock_status_data = \App\StockStatus::all()->toArray();
				//$stock_status_data = $stock_status_data[0];
				//echo "<pre>";print_r($stock_status_data);
				
				foreach($productsData as $productsDataArray) 
				{
					
					foreach($productsDataArray as $val)
					{					
						//Insert main product
						$product_data = new \App\Product;
						$product_data->name = $val['name'];
						$product_data->sku = $val['sku'];
						$product_data->weight = $val['weight'];				
						$product_data->stock_status_id = 0;
						//Find Product stock status refraance and store in product id in product table
						if(!empty($val['is_in_stock'])) {
							$stock_status_id = $this->searchForId($val['is_in_stock'], $stock_status_data);
							$product_data->stock_status_id = $stock_status_id;
						}				
						$product_data->qty = $val['qty'];
						$product_data->price = $val['price'];				
						$product_insert_id = $product_data->save();
												
						$product_insert_id = DB::getPdo()->lastInsertId(); //last insert id

						//insert Product Description				
						$product_description = new \App\ProductDescription;
						$product_description->product_id = $product_insert_id; // Product ID
						$product_description->description = $val['description'];
						$product_description->save();				
						
						//Find Product Attribute and insert in product attribute data				
						if(!empty($val['type']))
						{
							$atribute_type = $this->searchForId($val['type'], $attribute_data);
							$product_attribute = new \App\ProductAttribute;
							$product_attribute->product_id = $product_insert_id; // Product ID
							$product_attribute->attribute_id = $atribute_type;
							$product_attribute->text = $val['type'];
							$product_attribute->save();
						}
						
						if(!empty($val['color']))
						{
							$atribute_color = $this->searchForId($val['color'], $attribute_data);
							$product_attribute = new \App\ProductAttribute;
							$product_attribute->product_id = $product_insert_id;
							$product_attribute->attribute_id = $atribute_color;
							$product_attribute->text = $val['color'];
							$product_attribute->save();
						}
						
						if(!empty($val['size']))
						{				
							$atribute_size = $this->searchForId($val['size'], $attribute_data);				
							$product_attribute = new \App\ProductAttribute;
							$product_attribute->product_id = $product_insert_id;
							$product_attribute->attribute_id = $atribute_size;
							$product_attribute->text = $val['size'];
							$product_attribute->save();
						}
										
						//Store Product Images
						for($i=1;$i<=12;$i++) {					
							if(!empty($val['image'.$i]))
							{
								$product_image = new \App\ProductImage;
								$product_image->product_id = $product_insert_id;
								$product_image->image = $val['image'.$i]; 
								$product_image->save();
							}										
						}	
					}
				}		
			} 
			catch(ValidationException $e) 
			{
				// Rollback and then redirect
				DB::rollback();
				$commmit = 2;
			}

			if($commmit != 2) {
				// Commit the queries!
				DB::commit();
			}			
		}
	}
	
	/**
	* Find value from m.array
	**/
	function searchForId($id, $array) {
	   foreach ($array as $key => $val) {
		   if ($val['name'] == $id) {
			   return $key;
		   }
	   }
	   return 0;
	}
}
