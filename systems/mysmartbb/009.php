<?php
if (!defined('IDIR')) { die; }
/*======================================================================*\
|| ####################################################################
|| # vBulletin Impex
|| # ----------------------------------------------------------------
|| # All PHP code in this file is Copyright 2000-2014 vBulletin Solutions Inc.
|| # This code is made available under the Modified BSD License -- see license.txt
|| # http://www.vbulletin.com 
|| ####################################################################
\*======================================================================*/
/**
*
* @package			ImpEx.mysmartbb
*
*/

class mysmartbb_009 extends mysmartbb_000
{
	var $_dependent = '006';

	function mysmartbb_009(&$displayobject)
	{
		$this->_modulestring = $displayobject->phrases['import_poll'];
	}

	function init(&$sessionobject, &$displayobject, &$Db_target, &$Db_source)
	{
		$class_num = substr(get_class($this) , -3);

		if ($this->check_order($sessionobject,$this->_dependent))
		{
			if ($this->_restart)
			{
				if ($this->restart($sessionobject, $displayobject, $Db_target, $Db_source, 'clear_imported_polls'))
				{;
					$displayobject->display_now("<h4>{$displayobject->phrases['polls_cleared']}</h4>");
					$this->_restart = true;
				}
				else
				{
					$sessionobject->add_error($Db_target, 'fatal', $class_num, 0, $displayobject->phrases['poll_restart_failed'], $displayobject->phrases['check_db_permissions']);
				}
			}

			// Start up the table
			$displayobject->update_basic('title',$displayobject->phrases['import_poll']);
			$displayobject->update_html($displayobject->do_form_header('index', $class_num));
			$displayobject->update_html($displayobject->make_hidden_code($class_num, 'WORKING'));
			$displayobject->update_html($displayobject->make_table_header($this->_modulestring));

			// Ask some questions
			$displayobject->update_html($displayobject->make_input_code($displayobject->phrases['units_per_page'], 'perpage', 1000));

			// End the table
			$displayobject->update_html($displayobject->do_form_footer($displayobject->phrases['continue'],$displayobject->phrases['reset']));

			// Reset/Setup counters for this
			$sessionobject->add_session_var("009_objects_done", '0');
			$sessionobject->add_session_var("009_objects_failed", '0');
			$sessionobject->add_session_var('startat','0');
		}
		else
		{
			// Dependant has not been run
			$displayobject->update_html($displayobject->do_form_header('index', ''));
			$displayobject->update_html($displayobject->make_description("<p>{$displayobject->phrases['dependant_on']}<i><b> " . $sessionobject->get_module_title($this->_dependent) . "</b> {$displayobject->phrases['cant_run']}</i> ."));
			$displayobject->update_html($displayobject->do_form_footer($displayobject->phrases['continue'],''));
			$sessionobject->set_session_var($class_num, 'FALSE');
			$sessionobject->set_session_var('module','000');
		}
	}

	function resume(&$sessionobject, &$displayobject, &$Db_target, &$Db_source)
	{
		// Set up working variables.
		$displayobject->update_basic('displaymodules','FALSE');
		$t_db_type		= $sessionobject->get_session_var('targetdatabasetype');
		$t_tb_prefix	= $sessionobject->get_session_var('targettableprefix');
		$s_db_type		= $sessionobject->get_session_var('sourcedatabasetype');
		$s_tb_prefix	= $sessionobject->get_session_var('sourcetableprefix');

		// Per page vars
		$start_at		= $sessionobject->get_session_var('startat');
		$per_page		= $sessionobject->get_session_var('perpage');
		$class_num		= substr(get_class($this) , -3);

		// Start the timing
		if(!$sessionobject->get_session_var("{$class_num}_start"))
		{
			$sessionobject->timing($class_num , 'start' ,$sessionobject->get_session_var('autosubmit'));
		}

		// Get an array data
		$data_array = $this->get_source_data($Db_source, $s_db_type, "{$s_tb_prefix}poll", 'id', 0, $start_at, $per_page);
		$thread_ids_array = $this->get_threads_ids($Db_target, $t_db_type, $t_tb_prefix);

		// Display count and pass time
		$displayobject->print_per_page_pass($data_array['count'], $displayobject->phrases['polls'], $start_at);

		$ImpExData_object = new ImpExData($Db_target, $sessionobject, 'poll');

		foreach ($data_array['data'] as $import_id => $data)
		{
			$try = (phpversion() < '5' ? $ImpExData_object : clone($ImpExData_object));

			unset($polls_results_array, $poll_voters, $numberoptions, $voters, $options, $votes);

			if ($data['ans1'])
			{
				$options 	.= $option['ans1'] 	. '|||';
				$votes 		.= $option['res1'] . '|||';
				$voters		+= intval($option['res1']);
				$numberoptions++;
			}

			if ($data['ans2'])
			{
				$options 	.= $option['ans2'] 	. '|||';
				$votes 		.= $option['res2'] . '|||';
				$voters		+= intval($option['res2']);
				$numberoptions++;
			}

			if ($data['ans3'])
			{
				$options 	.= $option['ans3'] 	. '|||';
				$votes 		.= $option['res3'] . '|||';
				$voters		+= intval($option['res3']);
				$numberoptions++;
			}

			if ($data['ans4'])
			{
				$options 	.= $option['ans4'] 	. '|||';
				$votes 		.= $option['res4'] . '|||';
				$voters		+= intval($option['res4']);
				$numberoptions++;
			}

			if ($data['ans5'])
			{
				$options 	.= $option['ans5'] 	. '|||';
				$votes 		.= $option['res5'] . '|||';
				$voters		+= intval($option['res5']);
				$numberoptions++;
			}

			if ($data['ans6'])
			{
				$options 	.= $option['ans6'] 	. '|||';
				$votes 		.= $option['res6'] . '|||';
				$voters		+= intval($option['res6']);
				$numberoptions++;
			}

			if ($data['ans7'])
			{
				$options 	.= $option['ans7'] 	. '|||';
				$votes 		.= $option['res7'] . '|||';
				$voters		+= intval($option['res7']);
				$numberoptions++;
			}

			if ($data['ans8'])
			{
				$options 	.= $option['ans8'] 	. '|||';
				$votes 		.= $option['res8'] . '|||';
				$voters		+= intval($option['res8']);
				$numberoptions++;
			}


			$options = substr($options, 0, -3);
			$votes = substr($votes, 0, -3);

			// Mandatory
			$try->set_value('mandatory', 'question',			$data["qus"]);
			$try->set_value('mandatory', 'importpollid',		$import_id);
			$try->set_value('mandatory', 'votes',				$votes);
			$try->set_value('mandatory', 'options',				$options);
			$try->set_value('mandatory', 'dateline',			$this->get_thread_date($Db_target, $t_db_type, $t_tb_prefix, $data['subject_id']));

			// Non mandatory
			$try->set_value('nonmandatory', 'active',			'1');
			$try->set_value('nonmandatory', 'numberoptions',	intval($numberoptions));
			$try->set_value('nonmandatory', 'multiple',			'0');
			$try->set_value('nonmandatory', 'voters',			$voters);
			$try->set_value('nonmandatory', 'public',			'1');
			$try->set_value('nonmandatory', 'lastvote',			'0');
			$try->set_value('nonmandatory', 'timeout',			'0');

			// Check if object is valid
			if($try->is_valid())
			{
				if($try->import_poll($Db_target, $t_db_type, $t_tb_prefix))
				{
					$displayobject->display_now('<br /><span class="isucc"><b>' . $try->how_complete() . '%</b></span> ' . $displayobject->phrases['poll'] . ' -> ' . $data['qus']);
					$sessionobject->add_session_var("{$class_num}_objects_done",intval($sessionobject->get_session_var("{$class_num}_objects_done")) + 1 );
				}
				else
				{
					$sessionobject->add_session_var("{$class_num}_objects_failed",intval($sessionobject->get_session_var("{$class_num}_objects_failed")) + 1 );
					$sessionobject->add_error($Db_target, 'warning', $class_num, $import_id, $displayobject->phrases['poll_not_imported'], $displayobject->phrases['poll_not_imported_rem']);
					$displayobject->display_now("<br />{$displayobject->phrases['failed']} :: {$displayobject->phrases['poll_not_imported']}");
				}// $try->import_poll
			}
			else
			{
				$sessionobject->add_session_var("{$class_num}_objects_failed",intval($sessionobject->get_session_var("{$class_num}_objects_failed")) + 1 );
				$sessionobject->add_error($Db_target, 'invalid', $class_num, $import_id, $displayobject->phrases['invalid_object'] . ' ' . $try->_failedon, $displayobject->phrases['invalid_object_rem']);
				$displayobject->display_now("<br />{$displayobject->phrases['invalid_object']}" . $try->_failedon);
			}// is_valid
			unset($try);
		}// End foreach

		// Check for page end
		if ($data_array['count'] == 0 OR $data_array['count'] < $per_page)
		{
			$sessionobject->timing($class_num, 'stop', $sessionobject->get_session_var('autosubmit'));
			$sessionobject->remove_session_var("{$class_num}_start");

			$displayobject->update_html($displayobject->module_finished($this->_modulestring,
				$sessionobject->return_stats($class_num, '_time_taken'),
				$sessionobject->return_stats($class_num, '_objects_done'),
				$sessionobject->return_stats($class_num, '_objects_failed')
			));

			$sessionobject->set_session_var($class_num , 'FINISHED');
			$sessionobject->set_session_var('module', '000');
			$sessionobject->set_session_var('autosubmit', '0');
		}

		$sessionobject->set_session_var('startat', $data_array['lastid']);
		$displayobject->update_html($displayobject->print_redirect('index.php',$sessionobject->get_session_var('pagespeed')));
	}// End resume
}//End Class
# Autogenerated on : January 18, 2007, 1:49 pm
# By ImpEx-generator 2.0
/*======================================================================*/
?>
