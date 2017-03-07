<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \DateTime;

class WaitingList extends Model {

	public $table = 'waitinglists';

	public static function getListOfStudent($area, $limit) {
		return WaitingList::where('area', $area)
			->orderBy('updated_at', 'desc')
			->take($limit);
	}

	public static function getCallButton($id, $area) {

		if (!WaitingList::where('id', 0)->where('area', $area)->exists()) {
			return '';
		} else {
			$time = new DateTime();
			$record = WaitingList::where('id', $id)->where('area', $area)->first();
			return ($record == null or $record->updated_at == null or ($time->getTimestamp() - $record->updated_at->format('U')) > env('TIME_LIMIT_PER_CALL_REQUEST', 30))
				? 'active'
				: 'inactive';
		}
	}
}
