<?php

namespace App\Http\Transformers;

use Carbon\Carbon;

class ProductTransformer
{	
	/**
	 * Transforms a data attribute names to match its models fillables.
	 *
	 * @param  array	$products
	 * @return array
	 */
	public static function transformProducts(array $products) : array
	{
		return collect($products)->map(function ($product) {
			if (array_key_exists('Id', $product)) {
				$product['id'] = $product['Id'];
			
				unset($product['Id']);
			}
			
			if (array_key_exists('ImportID', $product)) {
				$product['import_id'] = $product['ImportID'];
				
				unset($product['ImportID']);
			}
			
			if (array_key_exists('Name', $product)) {
				$product['title'] = $product['Name'];
				
				$product['slug'] = str_slug($product['Name']);
			
				unset($product['Name']);
			}
			
			if (array_key_exists('SortOrder', $product)) {
				$product['sort_order'] = $product['SortOrder'];
				
				unset($product['SortOrder']);
			}
			
			if (array_key_exists('CategoryId', $product)) {
				$product['product_category_id'] = $product['CategoryId'];
				
				unset($product['CategoryId']);
			}
			
			if (array_key_exists('ManufacturerId', $product)) {
				$product['product_manufacturer_id'] = $product['ManufacturerId'];
				
				unset($product['ManufacturerId']);
			}
			
			if (array_key_exists('HarmonisedCodeId', $product)) {
				$product['harmonised_code_id'] = $product['HarmonisedCodeId'];
				
				unset($product['HarmonisedCodeId']);
			}
			
			if (array_key_exists('SupplierId', $product)) {
				$product['supplier_id'] = $product['SupplierId'];
				
				unset($product['SupplierId']);
			}
			
			if (array_key_exists('VatRateId', $product)) {
				$product['product_vat_rate_id'] = $product['VatRateId'];
				
				unset($product['VatRateId']);
			}
			
			if (array_key_exists('LimitedLife', $product)) {
				$product['limited_life'] = $product['LimitedLife'];
				
				unset($product['LimitedLife']);
			}
			
			if (array_key_exists('TestCertificatesRequired', $product)) {
				$product['test_certificates_required'] = $product['TestCertificatesRequired'];
				
				unset($product['TestCertificatesRequired']);
			}
			
			if (array_key_exists('CommodityNameProtocol', $product)) {
				$product['commodity_name_protocol'] = $product['CommodityNameProtocol'];
				
				unset($product['CommodityNameProtocol']);
			}
			
			if (array_key_exists('CommodityCodeProtocol', $product)) {
				$product['commodity_code_protocol'] = $product['CommodityCodeProtocol'];
				
				unset($product['CommodityCodeProtocol']);
			}
			
			if (array_key_exists('CommodityShortDescriptionProtocol', $product)) {
				$product['commodity_short_description_protocol'] = $product['CommodityShortDescriptionProtocol'];
				
				unset($product['CommodityShortDescriptionProtocol']);
			}
			
			if (array_key_exists('RetireDate', $product)) {
				$product['retire_date'] = $product['RetireDate'];
				
				unset($product['RetireDate']);
			}	
			
			if (array_key_exists('RetireEmployeeId', $product)) {
				$product['retire_employee_id'] = $product['RetireEmployeeId'];
				
				unset($product['RetireEmployeeId']);
			}	
			
			if (array_key_exists('Description', $product)) {
				$product['description'] = $product['Description'];
				
				unset($product['Description']);
			}
			
			if (array_key_exists('ShortName', $product)) {
				$product['short_name'] = $product['ShortName'];
				
				unset($product['ShortName']);
			}
			
			if (array_key_exists('ImageURI', $product)) {
				$product['image_uri'] = $product['ImageURI'];
				
				unset($product['ImageURI']);
			}
			
			$now = Carbon::now()->format('Y-m-d H:i:s');
			
			$product['created_at'] = $now;
			
			$product['updated_at'] = $now;
			
			return $product;
		})->toArray();	
	}
	
	/**
	 * Transforms a data attribute names to match its models fillables.
	 *
	 * @param  array	$productCategories
	 * @return array
	 */
	public static function transformProductCategories(array $productCategories) : array
	{
		return collect($productCategories)->map(function ($productCategory) {
			if (array_key_exists('Id', $productCategory)) {
				$productCategory['id'] = $productCategory['Id'];
				
				unset($productCategory['Id']);
			}
			
			if (array_key_exists('Name', $productCategory)) {
				$productCategory['title'] = $productCategory['Name'];
				
				$productCategory['slug'] = str_slug($productCategory['Name']);
				
				unset($productCategory['Name']);
			}
					
			if (array_key_exists('Description', $productCategory)) {
				$productCategory['description'] = $productCategory['Description'];
				
				unset($productCategory['Description']);
			}
			
			if (array_key_exists('ParentId', $productCategory)) {
				$productCategory['parent_id'] = $productCategory['ParentId'];
				
				unset($productCategory['ParentId']);
			}
			
			if (array_key_exists('SortOrder', $productCategory)) {
				$productCategory['sort_order'] = $productCategory['SortOrder'];
				
				unset($productCategory['SortOrder']);
			}
			
			if (array_key_exists('ImportID', $productCategory)) {
				$productCategory['import_id'] = $productCategory['ImportID'];
				
				unset($productCategory['ImportID']);
			}
			
			if (array_key_exists('ImageURI', $productCategory)) {
				$productCategory['image_uri'] = $productCategory['ImageURI'];
				
				unset($productCategory['ImageURI']);
			}
			
			if (array_key_exists('PublishToWeb', $productCategory)) {
				$productCategory['publish_to_web'] = $productCategory['PublishToWeb'];
				
				unset($productCategory['PublishToWeb']);
			}
			
			$now = Carbon::now()->format('Y-m-d H:i:s');
			
			$productCategory['created_at'] = $now;
			
			$productCategory['updated_at'] = $now;
			
			return $productCategory;
		})->toArray();
	}
	
	/**
	 * Transforms a data attribute names to match its models fillables.
	 *
	 * @param  array	$productCommodities
	 * @return array
	 */
	public static function transformProductCommodities(array $productCommodities) : array
	{
		return collect($productCommodities)->map(function ($productCommodity) {
			if (array_key_exists('Id', $productCommodity)) {
				$productCommodity['id'] = $productCommodity['Id'];
			
				unset($productCommodity['Id']);
			}
		
			if (array_key_exists('Name', $productCommodity)) {
				$productCommodity['title'] = $productCommodity['Name'];
			
				unset($productCommodity['Name']);
			}
			
			if (array_key_exists('IsDirty', $productCommodity)) {
				$productCommodity['is_dirty'] = $productCommodity['IsDirty'];
			
				unset($productCommodity['IsDirty']);
			}
			
			if (array_key_exists('Weight', $productCommodity)) {	
				$productCommodity['weight'] = $productCommodity['Weight'];
			
				unset($productCommodity['Weight']);
			}
			
			if (array_key_exists('WeightPer', $productCommodity)) {	
				$productCommodity['weight_per'] = $productCommodity['WeightPer'];
			
				unset($productCommodity['WeightPer']);
			}
			
			if (array_key_exists('InternalPartNumber', $productCommodity)) {	
				$productCommodity['internal_part_number'] = $productCommodity['InternalPartNumber'];
			
				unset($productCommodity['InternalPartNumber']);
			}
			
			if (array_key_exists('Timecheck', $productCommodity)) {	
				$productCommodity['timecheck'] = $productCommodity['Timecheck'];
			
				unset($productCommodity['Timecheck']);
			}
			
			if (array_key_exists('Code', $productCommodity)) {	
				$productCommodity['code'] = $productCommodity['Code'];
			
				unset($productCommodity['Code']);
			}
			
			if (array_key_exists('CreatedUserId', $productCommodity)) {	
				$productCommodity['created_user_id'] = $productCommodity['CreatedUserId'];
			
				unset($productCommodity['CreatedUserId']);
			}
			
			if (array_key_exists('CreatedTime', $productCommodity)) {
				$productCommodity['created_time'] = $productCommodity['CreatedTime'];
			
				unset($productCommodity['CreatedTime']);
			}
			
			if (array_key_exists('ApprovalEmployeeId', $productCommodity)) {	
				$productCommodity['approval_employee_id'] = $productCommodity['ApprovalEmployeeId'];
			
				unset($productCommodity['ApprovalEmployeeId']);
			}
			
			if (array_key_exists('ApprovalDate', $productCommodity)) {
				$productCommodity['approval_date'] = $productCommodity['ApprovalDate'];
			
				unset($productCommodity['ApprovalDate']);
			}
			
			if (array_key_exists('RetireDate', $productCommodity)) {
				$productCommodity['retire_date'] = $productCommodity['RetireDate'];
			
				unset($productCommodity['RetireDate']);
			}
			
			if (array_key_exists('RetireEmployeeId', $productCommodity)) {
				$productCommodity['retire_employee_id'] = $productCommodity['RetireEmployeeId'];
			
				unset($productCommodity['RetireEmployeeId']);
			}
			
			if (array_key_exists('ShortDescription', $productCommodity)) {
				$productCommodity['short_description'] = $productCommodity['ShortDescription'];
			
				unset($productCommodity['ShortDescription']);
			}
			
			if (array_key_exists('ProductId', $productCommodity)) {
				$productCommodity['product_id'] = $productCommodity['ProductId'];
			
				unset($productCommodity['ProductId']);
			}
			
			if (array_key_exists('LegacyMatched', $productCommodity)) {
				$productCommodity['legacy_matched'] = $productCommodity['LegacyMatched'];
			
				unset($productCommodity['LegacyMatched']);
			}
			
			if (array_key_exists('QuantityAvailable', $productCommodity)) {
				$productCommodity['quantity_available'] = $productCommodity['QuantityAvailable'];
			
				unset($productCommodity['QuantityAvailable']);
			}
			
			if (array_key_exists('PriceBandId', $productCommodity)) {
				$productCommodity['price_band_id'] = $productCommodity['PriceBandId'];
			
				unset($productCommodity['PriceBandId']);
			}
			
			if (array_key_exists('PackQuantity', $productCommodity)) {
				$productCommodity['pack_quantity'] = $productCommodity['PackQuantity'];
			
				unset($productCommodity['PackQuantity']);
			}
			
			if (array_key_exists('CountryOfOriginID', $productCommodity)) {
				$productCommodity['country_of_origin_id'] = $productCommodity['CountryOfOriginID'];
			
				unset($productCommodity['CountryOfOriginID']);
			}
			
			$now = Carbon::now()->format('Y-m-d H:i:s');
			
			$productCommodity['created_at'] = $now;
			
			$productCommodity['updated_at'] = $now;
			
			return $productCommodity;
		})->toArray();
	}
	
	/**
	 * Transforms a data attribute names to match its models fillables.
	 *
	 * @param  array	$productCharacteristics
	 * @return array
	 */
	public static function transformProductCharacteristics(array $productCharacteristics) : array
	{
		return collect($productCharacteristics)->map(function ($productCharacteristic) {
			if (array_key_exists('Id', $productCharacteristic)) {
				$productCharacteristic['id'] = $productCharacteristic['Id'];
			
				unset($productCharacteristic['Id']);
			}
			
			if (array_key_exists('AttributeId', $productCharacteristic)) {
				$productCharacteristic['product_attribute_id'] = $productCharacteristic['AttributeId'];
			
				unset($productCharacteristic['AttributeId']);
			}
			
			if (array_key_exists('Value', $productCharacteristic)) {
				$productCharacteristic['value'] = $productCharacteristic['Value'];
			
				unset($productCharacteristic['Value']);
			}
			
			if (array_key_exists('CommodityCodeRepresentation', $productCharacteristic)) {
				$productCharacteristic['commodity_code_representation'] = $productCharacteristic['CommodityCodeRepresentation'];
			
				unset($productCharacteristic['CommodityCodeRepresentation']);
			}
	
			$now = Carbon::now()->format('Y-m-d H:i:s');
			
			$productCharacteristic['created_at'] = $now;
			
			$productCharacteristic['updated_at'] = $now;
			
			return $productCharacteristic;
		})->toArray();
	}
	
	/**
	 * Transforms a data attribute names to match its models fillables.
	 *
	 * @param  array	$productManufacturers
	 * @return array
	 */
	public static function transformProductManufacturers(array $productManufacturers) : array
	{
		return collect($productManufacturers)->map(function ($productManufacturer) {
			if (array_key_exists('Id', $productManufacturer)) {
				$productManufacturer['id'] = $productManufacturer['Id'];
			
				unset($productManufacturer['Id']);
			}
			
			if (array_key_exists('Name', $productManufacturer)) {
				$productManufacturer['title'] = $productManufacturer['Name'];
				
				$productManufacturer['slug'] = str_slug($productManufacturer['Name']);
			
				unset($productManufacturer['Name']);
			}
			
			if (array_key_exists('Website', $productManufacturer)) {
				$productManufacturer['website'] = str_replace('http://http://', 'http://', $productManufacturer['Website']);
			
				unset($productManufacturer['Website']);
			}
			
			if (array_key_exists('LogoImage', $productManufacturer)) {
				$productManufacturer['logo_image'] = $productManufacturer['LogoImage'];
			
				unset($productManufacturer['LogoImage']);
			}
			
			if (array_key_exists('CMSPageName', $productManufacturer)) {
				$productManufacturer['cms_page_name'] = $productManufacturer['CMSPageName'];
			
				unset($productManufacturer['CMSPageName']);
			}
			
			$now = Carbon::now()->format('Y-m-d H:i:s');
			
			$productManufacturer['created_at'] = $now;
			
			$productManufacturer['updated_at'] = $now;
			
			return $productManufacturer;
		})->toArray();
	}
	
	/**
	 * Transforms a data attribute names to match its models fillables.
	 *
	 * @param  array	$productStandards
	 * @return array
	 */
	public static function transformProductStandards(array $productStandards) : array
	{
		return collect($productStandards)->map(function ($productStandard) {
			if (array_key_exists('Id', $productStandard)) {
				$productStandard['id'] = $productStandard['Id'];
			
				unset($productStandard['Id']);
			}
		
			if (array_key_exists('Name', $productStandard)) {
				$productStandard['title'] = $productStandard['Name'];
			
				unset($productStandard['Name']);
			}
				
			if (array_key_exists('Code', $productStandard)) {
				$productStandard['code'] = $productStandard['Code'];
			
				unset($productStandard['Code']);
			}
				
			if (array_key_exists('FurtherDetails', $productStandard)) {
				$productStandard['further_details'] = $productStandard['FurtherDetails'];
			
				unset($productStandard['FurtherDetails']);
			}
			
			if (array_key_exists('StandardsOrganisationId', $productStandard)) {
				$productStandard['product_standard_organisation_id'] = $productStandard['StandardsOrganisationId'];
			
				unset($productStandard['StandardsOrganisationId']);
			}
			
			$now = Carbon::now()->format('Y-m-d H:i:s');
			
			$productStandard['created_at'] = $now;
			
			$productStandard['updated_at'] = $now;
			
			return $productStandard;
		})->toArray();
	}
	
	/**
	 * Transforms a data attribute names to match its models fillables.
	 *
	 * @param  array	$productStandards
	 * @return array
	 */
	public static function transformProductStandard(array $productStandards) : array
	{
		return collect($productStandards)->map(function ($productStandard) {
			unset($productStandard['Id']);
			
			if (array_key_exists('ProductId', $productStandard)) {
				$productStandard['product_id'] = $productStandard['ProductId'];
			
				unset($productStandard['ProductId']);
			}
		
			if (array_key_exists('StandardId', $productStandard)) {
				$productStandard['product_standard_id'] = $productStandard['StandardId'];
			
				unset($productStandard['StandardId']);
			}
			
			return $productStandard;
		})->toArray();
	}
	
	/**
	 * Transforms a data attribute names to match its models fillables.
	 *
	 * @param  array	$productStandardOrganisations
	 * @return array
	 */
	public static function transformProductStandardOrganisations(array $productStandardOrganisations) : array
	{
		return collect($productStandardOrganisations)->map(function ($productStandardOrganisation) {
			if (array_key_exists('Id', $productStandardOrganisation)) {
				$productStandardOrganisation['id'] = $productStandardOrganisation['Id'];
			
				unset($productStandardOrganisation['Id']);
			}
		
			if (array_key_exists('Name', $productStandardOrganisation)) {
				$productStandardOrganisation['title'] = $productStandardOrganisation['Name'];
			
				unset($productStandardOrganisation['Name']);
			}
		
			if (array_key_exists('Website', $productStandardOrganisation)) {
				$productStandardOrganisation['website'] = $productStandardOrganisation['Website'];
			
				unset($productStandardOrganisation['Website']);
			}
		
			if (array_key_exists('Description', $productStandardOrganisation)) {
				$productStandardOrganisation['description'] = $productStandardOrganisation['Description'];
			
				unset($productStandardOrganisation['Description']);
			}
		
			if (array_key_exists('Timecheck', $productStandardOrganisation)) {
				$productStandardOrganisation['timecheck'] = $productStandardOrganisation['Timecheck'];
			
				unset($productStandardOrganisation['Timecheck']);
			}
		
			$now = Carbon::now()->format('Y-m-d H:i:s');
			
			$productStandardOrganisation['created_at'] = $now;
			
			$productStandardOrganisation['updated_at'] = $now;
			
			return $productStandardOrganisation;
		})->toArray();
	}
	
	/**
	 * Transforms a data attribute names to match its models fillables.
	 *
	 * @param  array	$productAttributes
	 * @return array
	 */
	public static function transformProductAttribute(array $productAttributes) : array
	{
		return collect($productAttributes)->map(function ($productAttribute) {
			unset($productAttribute['Id']);
			
			if (array_key_exists('ProductId', $productAttribute)) {
				$productAttribute['product_id'] = $productAttribute['ProductId'];
				
				unset($productAttribute['ProductId']);
			}
			
			if (array_key_exists('AttributeId', $productAttribute)) {
				$productAttribute['product_attribute_id'] = $productAttribute['AttributeId'];
				
				unset($productAttribute['AttributeId']);
			}
			
			if (array_key_exists('FixedCharacteristicId', $productAttribute)) {
				$productAttribute['product_characteristic_id'] = $productAttribute['FixedCharacteristicId'];
				
				unset($productAttribute['FixedCharacteristicId']);
			}
			
			if (array_key_exists('DisplayPosition', $productAttribute)) {
				$productAttribute['display_position'] = $productAttribute['DisplayPosition'];
				
				unset($productAttribute['DisplayPosition']);
			}
			
			return $productAttribute;
		})->toArray();
	}
	
	/**
	 * Transforms a data attribute names to match its models fillables.
	 *
	 * @param  array	$productAttributes
	 * @return array
	 */
	public static function transformProductAttributes(array $productAttributes) : array
	{
		return collect($productAttributes)->map(function ($productAttribute) {
			if (array_key_exists('Id', $productAttribute)) {
				$productAttribute['id'] = $productAttribute['Id'];
				
				unset($productAttribute['Id']);
			}
		
			if (array_key_exists('Name', $productAttribute)) {
				$productAttribute['title'] = $productAttribute['Name'];
				
				unset($productAttribute['Name']);
			}
		
			$now = Carbon::now()->format('Y-m-d H:i:s');
			
			$productAttribute['created_at'] = $now;
			
			$productAttribute['updated_at'] = $now;
			
			return $productAttribute;
		})->toArray();
	}
	
	/**
	 * Transforms a data attribute names to match its models fillables.
	 *
	 * @param  array	$productVatRates
	 * @return array
	 */
	public static function transformProductVatRates(array $productVatRates) : array
	{
		return collect($productVatRates)->map(function ($productVatRate) {
			if (array_key_exists('Id', $productVatRate)) {
				$productVatRate['id'] = $productVatRate['Id'];
				
				unset($productVatRate['Id']);
			}
		
			if (array_key_exists('Code', $productVatRate)) {
				$productVatRate['code'] = $productVatRate['Code'];
				
				unset($productVatRate['Code']);
			}	
			
			if (array_key_exists('Description', $productVatRate)) {
				$productVatRate['description'] = $productVatRate['Description'];
				
				unset($productVatRate['Description']);
			}	
			
			if (array_key_exists('Rate', $productVatRate)) {
				$productVatRate['rate'] = $productVatRate['Rate'];
				
				unset($productVatRate['Rate']);
			}	
			
			if (array_key_exists('RateDisplay', $productVatRate)) {
				$productVatRate['rate_display'] = $productVatRate['RateDisplay'];
				
				unset($productVatRate['RateDisplay']);
    		}
		
			$now = Carbon::now()->format('Y-m-d H:i:s');
			
			$productVatRate['created_at'] = $now;
			
			$productVatRate['updated_at'] = $now;
			
			return $productVatRate;
		})->toArray();
	}
}
