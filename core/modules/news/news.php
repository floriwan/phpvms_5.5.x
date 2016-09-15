<?php
/**
 * phpVMS - Virtual Airline Administration Software
 * Copyright (c) 2008 Nabeel Shahzad
 * For more information, visit www.phpvms.net
 *	Forums: http://www.phpvms.net/forum
 *	Documentation: http://www.phpvms.net/docs
 *
 * phpVMS is licenced under the following license:
 *   Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
 *   View license.txt in the root, or visit http://creativecommons.org/licenses/by-nc-sa/3.0/
 *
 * @author Nabeel Shahzad
 * @copyright Copyright (c) 2008, Nabeel Shahzad
 * @link http://www.phpvms.net
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class News extends CodonModule
{
	public function index()
	{
		$this->ShowNewsFront(50);
	}

	// This function gets called directly in the template
	public function ShowNewsFront($count=5)
	{
		$sql='SELECT id, subject, body, postedby, UNIX_TIMESTAMP(postdate) AS postdate
				FROM ' . TABLE_PREFIX .'news
				ORDER BY postdate DESC
				LIMIT '.$count;

		$res = DB::get_results($sql);

		if(!$res)
			return;

    $this->set('allnews', $res);
    $this->show('news_newslist.tpl');

		/*
    foreach($res as $row)
		{
			//TODO: change the date format to a setting in panel
			$this->set('subject', $row->subject);
			$this->set('body', $row->body);
			$this->set('postedby', $row->postedby);
			$this->set('postdate', date(DATE_FORMAT, $row->postdate));

			$this->show('news_newsitem.tpl');
		}*/
	}

  /**
   * remove bbcode from the string
   */
  public function remove_bbcode($string) {
    $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
    $replace = '';
    return preg_replace($pattern, $replace, $string);
  }

  /**
   * search smf forum table for new news items and
   * insert them into the phpvms news table.
   */
  public function read_smf_news() {

    /* get the latest posting date */
    $sql = 'SELECT MAX( postdate ) as lastdate FROM ' . TABLE_PREFIX .'news';

    $res = DB::get_results($sql);
    //print_r($res);
    //echo "<p>latest phpvms news date " . $res[0]->lastdate . "</p>";

    //$sql = 'SELECT * FROM `smf_messages` WHERE id_board = 6';
    $sql = 'SELECT FROM_UNIXTIME(poster_time) as post_time, id_topic, subject, body FROM `smf_messages` WHERE id_board = 6 AND FROM_UNIXTIME(poster_time) > \'' . $res[0]->lastdate . '\'';
    //echo "<p>sql " . $sql . "</p>";
    $res = DB::get_results($sql);

    if ($res) {
      foreach ($res as $row) {

        // check if id_topic only exists once in the table.
        // Than we have the first posting.
        $sql = 'SELECT * FROM `smf_messages` WHERE id_topic = \'' . $row->id_topic . '\'';
        $res = DB::get_results($sql);

        // add only the first posting
        if (sizeof($res) == 1) {
          SiteData::AddNewsItem($row->subject, $this->remove_bbcode($row->body), "FCB Forum");
        }
      }
    }

  }

  public function ShowNewsPreview($count=10) {

    $this->read_smf_news();

    $sql='SELECT id, subject, body, postedby, UNIX_TIMESTAMP(postdate) AS postdate
				FROM ' . TABLE_PREFIX .'news
				ORDER BY postdate DESC
				LIMIT '.$count;

		$res = DB::get_results($sql);
    if (!$res) $res = [];

    $activity_data = ActivityData::getActivity();
    if (!$activity_data) $activity_data = [];

    $this->set('allnews', $res);
    $this->set('allactivities', $activity_data);
    $this->show('news_newspreview.tpl');

		/*foreach($res as $row)
		{
			//TODO: change the date format to a setting in panel
      $this->set('id', $row->id);
			$this->set('subject', $row->subject);
			$this->set('postedby', $row->postedby);
      $this->set('body', $row->body);
			$this->set('postdate', date(DATE_FORMAT, $row->postdate));

			$this->show('news_newspreview.tpl');
		}*/
  }
}
