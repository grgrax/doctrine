<?php
class donar_m extends CI_Model
{
	protected $table='tbl_donar';
	const PENDING=0;
	const ACTIVE=1;
	const SUCCESS=2;
	const FAIL=3;
	const BLOCKED=4;
	const DELETED=5;

	const file_path='campaign/';
	const full_path='uploads/files/pics/campaign/';

	function donar_of_campaign($campaign_id)
	{		
		// $this->db->select('*');
		// $this->db->from('blogs');
		// $this->db->join('comments', 'comments.id = blogs.id');
		// $query = $this->db->get();

		$query = $this->db->query('SELECT d.id, d.name, don.amount, don.comment, don.date
			FROM tbl_donar d
			JOIN tbl_donation don ON d.id = don.donar_id
			WHERE don.campaign_id = '.$campaign_id);
		return $query->result_array();
	}

	// function time_elapsed_string($ptime)
	// {
	// 	$etime = time() - $ptime;
	//     if ($etime < 1)
	//     {
	//         return '0 seconds';
	//     }
	//     $a = array( 365 * 24 * 60 * 60  =>  'year',
	//                  30 * 24 * 60 * 60  =>  'month',
	//                       24 * 60 * 60  =>  'day',
	//                            60 * 60  =>  'hour',
	//                                 60  =>  'minute',
	//                                  1  =>  'second'
	//                 );
	//     $a_plural = array( 'year'   => 'years',
	//                        'month'  => 'months',
	//                        'day'    => 'days',
	//                        'hour'   => 'hours',
	//                        'minute' => 'minutes',
	//                        'second' => 'seconds'
	//                 );
	//     foreach ($a as $secs => $str)
	//     {
	//         $d = $etime / $secs;
	//         if ($d >= 1)
	//         {
	//             $r = round($d);
	//             return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
	//         }
	//     }
	// }

	// function time_left_string($ptime)
	// {
	// 	$etime =  $ptime - time();
	//     if ($etime < 1)
	//     {
	//         return '0 seconds';
	//     }
	//     $a = array( 365 * 24 * 60 * 60  =>  'year',
	//                  30 * 24 * 60 * 60  =>  'month',
	//                       24 * 60 * 60  =>  'day',
	//                            60 * 60  =>  'hour',
	//                                 60  =>  'minute',
	//                                  1  =>  'second'
	//                 );
	//     $a_plural = array( 'year'   => 'years',
	//                        'month'  => 'months',
	//                        'day'    => 'days',
	//                        'hour'   => 'hours',
	//                        'minute' => 'minutes',
	//                        'second' => 'seconds'
	//                 );
	//     foreach ($a as $secs => $str)
	//     {
	//         $d = $etime / $secs;
	//         if ($d >= 1)
	//         {
	//             $r = round($d);
	//             return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' left';
	//         }
	//     }
	// }
}