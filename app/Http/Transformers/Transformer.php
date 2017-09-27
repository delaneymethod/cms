<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Http\Transformers;

abstract class Transformer
{
	public abstract function transformProducts(array $data);
	
	public abstract function transformProductCategories(array $data);
	
	public abstract function transformProductCommodities(array $data);
	
	public abstract function transformProductCharacteristics(array $data);
	
	public abstract function transformProductManufacturers(array $data);
	
	public abstract function transformProductStandards(array $data);
	
	public abstract function transformProductStandard(array $data);
	
	public abstract function transformProductStandardOrganisations(array $data);
	
	public abstract function transformProductAttribute(array $data);
	
	public abstract function transformProductAttributes(array $data);
	
	public abstract function transformProductVatRates(array $data);
}
