<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;
}
