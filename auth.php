<?php
	
	/**
	 * 	@root TPO
	**/
	define('EXROOT', dirname(__FILE__).DIRECTORY_SEPARATOR.'../');
	ini_set('display_errors', 'on');
	
	/**
	 *	@config System
	**/
	$EMERGENCY = false && !isset($_COOKIE['tamasomajyothirgamaya']);
	$STATUS = '<span class="state loading">Loading T&P Portal ...</span>';
	//$STATUS = '<span class="state">System maintenance in progress.</span>';
	
	/**
	 * 	@initialize Configuration
	**/
	require_once(EXROOT. 'core/config.php');
	//require_once('core/'.$YEAR.'/config.php');
	
	/**
	 * 	@initialize System
	**/
	require_once(EXROOT. 'core/init.php');
	//Snowblozm::$debug = true;	
	
	/**
	 *	@check cookie for session
	**/
	if(isset($_COOKIE[COOKIEKEY])){
		$memory = Snowblozm::run(array(
			'service' => 'cbcore.session.info.workflow',
			'sessionid' => $_COOKIE[COOKIEKEY]
		), $memory);

		if( $memory[ 'valid' ] ){
			/**
			 *	@launch Person Find
			**/
			$memory = Snowblozm::run(array(
				'service' => 'invoke.launch.workflow.workflow',
				'message' => array(
					'service' => 'executive.student.find.workflow'
				)
			), $memory);
			//echo json_encode($memory);exit;
			
			/**
			 *	@launch Read response
			**/
			if($memory['valid'] && $memory['message']['valid']){
				$student = $memory['message'];
				$stdid = $student['stdid'];
				$memory['stowner'] = $student['student']['owner'];
				
				if($student['person']['username'] == 'tpo.itbhu' or $student['person']['username'] == 'vibhaj'){
					//$_POST[ 'username' ] = $_REQUEST[ 'username' ] = 'admin';
					//$_POST[ 'password' ] = $_REQUEST[ 'password' ] = 'password';
				}
				/*elseif( $memory['message']['btadmin'] ){
					$_POST[ 'username' ] = $_REQUEST[ 'username' ] = 'tpo';
					$_POST[ 'password' ] = $_REQUEST[ 'password' ] = 'password';
				}*/
				else {
					$_POST[ 'username' ] = $_REQUEST[ 'username' ] = 'student';
					$_POST[ 'password' ] = $_REQUEST[ 'password' ] = 'inspire';
				}
				
				$_GET[ 'mode' ] = $_REQUEST[ 'mode' ] = 'login';
				$_POST[ 'login' ] = $_REQUEST[ 'login' ] = 'Login';
				$_POST[ 'redirect' ] = $_REQUEST[ 'redirect' ] = './index.php?';

				//require_once( 'ucp.php' );
				//exit();
			}
		}
	}

	//echo "<h2>Please login to <a href='".ROOTPATH."'>TPO Portal</a></h2>";

?>