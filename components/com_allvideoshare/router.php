<?php

/*
 * @version		$Id: router.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

function AllVideoShareBuildRoute( &$query )
{
	$segments = array();
   
    if(isset($query['view'])) {
    	$segments[] = $query['view'];
        unset( $query['view'] );
    }
	
	if(isset($query['orderby'])) {
		if($query['orderby'] != 'default') {
			$segments[] = $query['orderby'];
		}
    	unset( $query['orderby'] );	
	}
	
    if(isset($query['slg'])) {
    	$segments[] = $query['slg'];
        unset( $query['slg'] );
    }
	
    return $segments;
}

function AllVideoShareParseRoute( $segments )
{
	$vars  = array();
	$order = array('default', 'latest', 'popular', 'random', 'featured');
	$count = count( $segments );

	if( $count >= 1 && $segments[0] ) {
    	$vars['view'] = $segments[0];
    }
	
	if( $count == 2 ) {
		if( in_array($segments[1], $order) ) {
			$vars['orderby'] = $segments[1];
		} else {
			$vars['slg'] = $segments[1];
		}
	} else if($count == 3) {
		$vars['orderby'] = $segments[1];
		$vars['slg'] = $segments[2];    	
	}

    return $vars;
}

?>