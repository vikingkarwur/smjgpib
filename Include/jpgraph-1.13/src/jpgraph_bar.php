<?php
/*=======================================================================
// File:	JPGRAPH_BAR.PHP
// Description:	Bar plot extension for JpGraph
// Created: 	2001-01-08
// Author:	Johan Persson (johanp@aditus.nu)
// Ver:		$Id: jpgraph_bar.php,v 1.3 2004/09/30 13:24:23 cah Exp $
//
// License:	This code is released under QPL
// Copyright (C) 2001,2002 Johan Persson
//========================================================================
*/

//===================================================
// CLASS BarPlot
// Description: Main code to produce a bar plot 
//===================================================
class BarPlot extends Plot {
    var $width=0.4; // in percent of major ticks
    var $abswidth=-1; // Width in absolute pixels
    var $fill=false,$fill_color="lightblue"; // Default is to fill with light blue
    var $ybase=0; // Bars start at 0 
    var $align="center";
    var $grad=false,$grad_style=1;
    var $grad_fromcolor=array(50,50,200),$grad_tocolor=array(255,255,255);
    var $bar_shadow=false;
    var $bar_shadow_color="black";
    var $bar_shadow_hsize=3,$bar_shadow_vsize=3;	
    var $valuepos='top';
	
//---------------
// CONSTRUCTOR
    function BarPlot(&$datay,$datax=false) {
	$this->Plot($datay,$datax);		
	++$this->numpoints;
    }

//---------------
// PUBLIC METHODS	
	
    // Set a drop shadow for the bar (or rather an "up-right" shadow)
    function SetShadow($color="black",$hsize=3,$vsize=3) {
	$this->bar_shadow=true;
	$this->bar_shadow_color=$color;
	$this->bar_shadow_vsize=$vsize;
	$this->bar_shadow_hsize=$hsize;
		
	// Adjust the value margin to compensate for shadow
	$this->value->margin += $vsize;
    }
		
    // DEPRECATED use SetYBase instead
    function SetYMin($aYStartValue) {
	//die("JpGraph Error: Deprecated function SetYMin. Use SetYBase() instead.");    	
	$this->ybase=$aYStartValue;
    }

    // Specify the base value for the bars
    function SetYBase($aYStartValue) {
	$this->ybase=$aYStartValue;
    }
	
    function Legend(&$graph) {
	if( $this->grad && $this->legend!="" && !$this->fill ) {
	    $color=array($this->grad_fromcolor,$this->grad_tocolor,$this->grad_style);
	    $graph->legend->Add($this->legend,$color,"",0,
				$this->legendcsimtarget,$this->legendcsimalt);
	}
	elseif( $this->fill_color && $this->legend!="" ) {
	    if( is_array($this->fill_color) )
		$graph->legend->Add($this->legend,$this->fill_color[0],"",0,
				    $this->legendcsimtarget,$this->legendcsimalt);
	    else
		$graph->legend->Add($this->legend,$this->fill_color,"",0,
				    $this->legendcsimtarget,$this->legendcsimalt);	
	}
    }

    // Gets called before any axis are stroked
    function PreStrokeAdjust(&$graph) {
	parent::PreStrokeAdjust($graph);

	// If we are using a log Y-scale we want the base to be at the
	// minimum Y-value unless the user have specifically set some other
	// value than the default.
	if( substr($graph->axtype,-3,3)=="log" && $this->ybase==0 )
	    $this->ybase = $graph->yaxis->scale->GetMinVal();
		
	// For a "text" X-axis scale we will adjust the
	// display of the bars a little bit.
	if( substr($graph->axtype,0,3)=="tex" ) {
	    // Position the ticks between the bars
	    $graph->xaxis->scale->ticks->SetXLabelOffset(0.5,0);

	    // Center the bars 
	    if( $this->align == "center" )
	    	$graph->SetTextScaleOff(0.5-$this->width/2);					
	    elseif( $this->align == "right" )
	    	$graph->SetTextScaleOff(1-$this->width);			

	}
	else {
	    // We only set an absolute width for linear and int scale
	    // for text scale the width will be set to a fraction of
	    // the majstep width.
	    if( $this->abswidth == -1 ) {
                // Not set
		// set width to a visuable sensible default
		$this->abswidth = $graph->img->plotwidth/(2*count($this->coords[0]));
	    }
	}
    }

    function Min() {
	$m = parent::Min();
	if( $m[1] >= $this->ybase )
	    $m[1] = $this->ybase;
	return $m;	
    }

    function Max() {
	$m = parent::Max();
	if( $m[1] <= $this->ybase )
	    $m[1] = $this->ybase;
	return $m;	
    }	
	
    // Specify width as fractions of the major stepo size
    function SetWidth($aFractionWidth) {
	$this->width=$aFractionWidth;
    }
	
    // Specify width in absolute pixels. If specified this
    // overrides SetWidth()
    function SetAbsWidth($aWidth) {
	$this->abswidth=$aWidth;
    }
		
    function SetAlign($aAlign) {
	$this->align=$aAlign;
    }
	
    function SetNoFill() {
	$this->grad = false;
	$this->fill_color=false;
	$this->fill=false;
    }
		
    function SetFillColor($aColor) {
	$this->fill = true ;
	$this->fill_color=$aColor;
    }
	
    function SetFillGradient($from_color,$to_color,$style) {
	$this->grad=true;
	$this->grad_fromcolor=$from_color;
	$this->grad_tocolor=$to_color;
	$this->grad_style=$style;
    }
	
    function SetValuePos($aPos) {
	$this->valuepos = $aPos;
    }

    function Stroke(&$img,&$xscale,&$yscale) { 
		
	$numpoints = count($this->coords[0]);
	if( isset($this->coords[1]) ) {
	    if( count($this->coords[1])!=$numpoints )
		die("JpGraph Error: Number of X and Y points are not equal.<br>
					Number of X-points:".count($this->coords[1])."<br>
					Number of Y-points:$numpoints");
	    else
		$exist_x = true;
	}
	else 
	    $exist_x = false;
		
		
	$numbars=count($this->coords[0]);

	// Use GetMinVal() instead of scale[0] directly since in the case
	// of log scale we get a correct value. Log scales will have negative
	// values for values < 1 while still not representing negative numbers.
	if( $yscale->GetMinVal() >= 0 ) 
	    $zp=$yscale->scale_abs[0]; 
	else {
	    $zp=$yscale->Translate(0);
	}

	if( $this->abswidth > -1 ) {
	    $abswidth=$this->abswidth;
	}
	else
	    $abswidth=round($this->width*$xscale->scale_factor,0);
					
	for($i=0; $i<$numbars; $i++) {

 	    // If value is NULL, or 0 then don't draw a bar at all
 	    if ($this->coords[0][$i] === null ||
		$this->coords[0][$i] === '' ||
		$this->coords[0][$i] === 0 ) continue;    

	    if( $exist_x ) $x=$this->coords[1][$i];
	    else $x=$i;
			
	    $x=$xscale->Translate($x);

	    if( !$xscale->textscale ) {
	    	if($this->align=="center")
		    $x -= $abswidth/2;
		elseif($this->align=="right")
		    $x -= $abswidth;			
	    }

	    $pts=array(
		$x,$zp,
		$x,$yscale->Translate($this->coords[0][$i]),
		$x+$abswidth,$yscale->Translate($this->coords[0][$i]),
		$x+$abswidth,$zp);
	    if( $this->grad ) {
		$grad = new Gradient($img);
		$grad->FilledRectangle($pts[2],$pts[3],
				       $pts[6],$pts[7],
				       $this->grad_fromcolor,$this->grad_tocolor,$this->grad_style); 
	    }
	    elseif( !empty($this->fill_color) ) {
		if(is_array($this->fill_color)) {
		    $img->PushColor($this->fill_color[$i % count($this->fill_color)]);
		} else {
		    $img->PushColor($this->fill_color);
		}
		$img->FilledPolygon($pts);
		$img->PopColor();
	    }
			
	    // Remember value of this bar
	    $val=$this->coords[0][$i];
			
	    if( $this->bar_shadow && $val !== 0 && $val !== 0.0 ) {
		$ssh = $this->bar_shadow_hsize;
		$ssv = $this->bar_shadow_vsize;
		// Create points to create a "upper-right" shadow
		if( $val > 0 ) {
		    $sp[0]=$pts[6];		$sp[1]=$pts[7];
		    $sp[2]=$pts[4];		$sp[3]=$pts[5];
		    $sp[4]=$pts[2];		$sp[5]=$pts[3];
		    $sp[6]=$pts[2]+$ssh;	$sp[7]=$pts[3]-$ssv;
		    $sp[8]=$pts[4]+$ssh;	$sp[9]=$pts[5]-$ssv;
		    $sp[10]=$pts[6]+$ssh;	$sp[11]=$pts[7]-$ssv;
		} 
		elseif( $val < 0 ) {
		    $sp[0]=$pts[4];		$sp[1]=$pts[5];
		    $sp[2]=$pts[6];		$sp[3]=$pts[7];
		    $sp[4]=$pts[0];	$sp[5]=$pts[1];
		    $sp[6]=$pts[0]+$ssh;	$sp[7]=$pts[1]-$ssv;
		    $sp[8]=$pts[6]+$ssh;	$sp[9]=$pts[7]-$ssv;
		    $sp[10]=$pts[4]+$ssh;	$sp[11]=$pts[5]-$ssv;
		}
				
		$img->PushColor($this->bar_shadow_color);
		$img->FilledPolygon($sp);
		$img->PopColor();
	    }
			
	    // Stroke the outline of the bar
	    if( is_array($this->color) )
		$img->SetColor($this->color[$i % count($this->color)]);
	    else
		$img->SetColor($this->color);

	    $pts[] = $pts[0];
	    $pts[] = $pts[1];

	    if( $this->weight > 0 ) {
		$img->SetLineWeight($this->weight);
		$img->Polygon($pts);
	    }
				
	    $x=$pts[2]+($pts[4]-$pts[2])/2;
	    if( $this->valuepos=='top' ) {
		$y=$pts[3];
		$this->value->Stroke($img,$val,$x,$y);
	    }
	    elseif( $this->valuepos=='max' ) {
		$y=$pts[3];
		if( $img->a === 90 ) {
		    $this->value->SetAlign('right','center');
		}
		else {
		    $this->value->SetAlign('center','top');
		}
		$this->value->SetMargin(-2);
		$this->value->Stroke($img,$val,$x,$y);
	    }
	    elseif( $this->valuepos=='center' ) {
		$y = ($pts[3] + $pts[1])/2;
		$this->value->SetAlign('center','center');
		$this->value->SetMargin(0);
		$this->value->Stroke($img,$val,$x,$y);
	    }
	    elseif( $this->valuepos=='bottom' || $this->valuepos=='min' ) {
		$y=$pts[1];
		$this->value->SetMargin(0);
		$this->value->Stroke($img,$val,$x,$y);
	    }
	    else {
		JpGraphError::Raise('Unknown position for values on bars :'.$this->valuepos);
		die();
	    }
	    // Create the client side image map
	    $rpts = $img->ArrRotate($pts);		
	    $csimcoord=round($rpts[0]).", ".round($rpts[1]);
	    for( $j=1; $j < 4; ++$j){
		$csimcoord .= ", ".round($rpts[2*$j]).", ".round($rpts[2*$j+1]);
	    }	    	    
	    if( !empty($this->csimtargets[$i]) ) {
		$this->csimareas .= '<area shape="poly" coords="'.$csimcoord.'" ';    	    
		$this->csimareas .= " href=\"".$this->csimtargets[$i]."\"";
		if( !empty($this->csimalts[$i]) ) {
		    $sval=sprintf($this->csimalts[$i],$this->coords[0][$i]);
		    $this->csimareas .= " alt=\"$sval\" title=\"$sval\" ";
		}
		$this->csimareas .= ">\n";
	    }
	}
	return true;
    }
} // Class

//===================================================
// CLASS GroupBarPlot
// Description: Produce grouped bar plots
//===================================================
class GroupBarPlot extends BarPlot {
    var $plots;
    var $width=0.7;
    var $nbrplots=0;
    var $numpoints;
//---------------
// CONSTRUCTOR
    function GroupBarPlot($plots) {
	$this->plots = $plots;
	$this->nbrplots = count($plots);
	$this->numpoints = $plots[0]->numpoints;
    }

//---------------
// PUBLIC METHODS	
    function Legend(&$graph) {
	$n = count($this->plots);
	for($i=0; $i<$n; ++$i)
	    $this->plots[$i]->DoLegend($graph);
    }
	
    function Min() {
	list($xmin,$ymin) = $this->plots[0]->Min();
	$n = count($this->plots);
	for($i=0; $i<$n; ++$i) {
	    list($xm,$ym) = $this->plots[$i]->Min();
	    $xmin = max($xmin,$xm);
	    $ymin = min($ymin,$ym);
	}
	return array($xmin,$ymin);		
    }
	
    function Max() {
	list($xmax,$ymax) = $this->plots[0]->Max();
	$n = count($this->plots);
	for($i=0; $i<$n; ++$i) {
	    list($xm,$ym) = $this->plots[$i]->Max();
	    $xmax = max($xmax,$xm);
	    $ymax = max($ymax,$ym);
	}
	return array($xmax,$ymax);
    }
	
    function GetCSIMareas() {
	$n = count($this->plots);
	$csimareas='';
	for($i=0; $i < $n; ++$i) {
	    $csimareas .= $this->plots[$i]->csimareas;
	}
	return $csimareas;
    }
	
    // Stroke all the bars next to each other
    function Stroke(&$img,&$xscale,&$yscale) { 
	$tmp=$xscale->off;
	$n = count($this->plots);
	$subwidth = $this->width/$this->nbrplots ; 
	for( $i=0; $i < $n; ++$i ) {
	    $this->plots[$i]->ymin=$this->ybase;
	    $this->plots[$i]->SetWidth($subwidth);
	    
	    // If the client have used SetTextTickInterval() then
	    // major_step will be > 1 and the positioning will fail.
	    // If we assume it is always one the positioning will work
	    // fine with a text scale but this will not work with
	    // arbitrary linear scale
	    $xscale->off = $tmp+$i*round(/*$xscale->ticks->major_step* */
					 $xscale->scale_factor*$subwidth);
	    $this->plots[$i]->Stroke($img,$xscale,$yscale);
	}
	$xscale->off=$tmp;
    }
} // Class

//===================================================
// CLASS AccBarPlot
// Description: Produce accumulated bar plots
//===================================================
class AccBarPlot extends BarPlot {
    var $plots=null,$nbrplots=0,$numpoints=0;
//---------------
// CONSTRUCTOR
    function AccBarPlot($plots) {
	$this->plots = $plots;
	$this->nbrplots = count($plots);
	$this->numpoints = $plots[0]->numpoints;		
	$this->value = new DisplayValue();
    }

//---------------
// PUBLIC METHODS	
    function Legend(&$graph) {
	$n = count($this->plots);
	for( $i=$n-1; $i>=0; --$i ) 
	    $this->plots[$i]->DoLegend($graph);
    }

    function Max() {
	list($xmax) = $this->plots[0]->Max();
	$nmax=0;
	for($i=0; $i<count($this->plots); ++$i) {
	    $n = count($this->plots[$i]->coords[0]);
	    $nmax = max($nmax,$n);
	    list($x) = $this->plots[$i]->Max();
	    $xmax = max($xmax,$x);
	}
	for( $i = 0; $i < $nmax; $i++ ) {
	    // Get y-value for bar $i by adding the
	    // individual bars from all the plots added.
	    // It would be wrong to just add the
	    // individual plots max y-value since that
	    // would in most cases give to large y-value.
	    $y=0;
	    if( $this->plots[0]->coords[0][$i] > 0 )
		$y=$this->plots[0]->coords[0][$i];
	    for( $j = 1; $j < $this->nbrplots; $j++ ) {
		if( $this->plots[$j]->coords[0][$i] > 0 )
		    $y += $this->plots[$j]->coords[0][$i];
	    }
	    $ymax[$i] = $y;
	}
	$ymax = max($ymax);

	// Bar always start at baseline
	if( $ymax <= $this->ybase ) 
	    $ymax = $this->ybase;
	return array($xmax,$ymax);
    }

    function Min() {
	$nmax=0;
	list($xmin,$ysetmin) = $this->plots[0]->Min();
	for($i=0; $i<count($this->plots); ++$i) {
	    $n = count($this->plots[$i]->coords[0]);
	    $nmax = max($nmax,$n);
	    list($x,$y) = $this->plots[$i]->Min();
	    $xmin = Min($xmin,$x);
	    $ysetmin = Min($y,$ysetmin);
	}
	for( $i = 0; $i < $nmax; $i++ ) {
	    // Get y-value for bar $i by adding the
	    // individual bars from all the plots added.
	    // It would be wrong to just add the
	    // individual plots max y-value since that
	    // would in most cases give to large y-value.
	    $y=$this->plots[0]->coords[0][$i];
	    for( $j = 1; $j < $this->nbrplots; $j++ ) {
		$y += $this->plots[ $j ]->coords[0][$i];
	    }
	    $ymin[$i] = $y;
	}
	$ymin = Min($ysetmin,Min($ymin));
	// Bar always start at baseline
	if( $ymin >= $this->ybase )
	    $ymin = $this->ybase;
	return array($xmin,$ymin);
    }

    // Stroke acc bar plot
    function Stroke(&$img,&$xscale,&$yscale) {
	$img->SetLineWeight($this->weight);
	for($i=0; $i<$this->numpoints-1; $i++) {
	    $accy = 0;
	    $accy_neg = 0; 
	    for($j=0; $j < $this->nbrplots; ++$j ) {				
	    
		$img->SetColor($this->plots[$j]->color);

		if ( $this->plots[$j]->coords[0][$i] >= 0) {
		    $yt=$yscale->Translate($this->plots[$j]->coords[0][$i]+$accy);
		    $accyt=$yscale->Translate($accy);
		    $accy+=$this->plots[$j]->coords[0][$i];
		}
		else {
		    //if ( $this->plots[$j]->coords[0][$i] < 0 || $accy_neg < 0 ) {
		    $yt=$yscale->Translate($this->plots[$j]->coords[0][$i]+$accy_neg);
		    $accyt=$yscale->Translate($accy_neg);
		    $accy_neg+=$this->plots[$j]->coords[0][$i];
		}				
				
		$xt=$xscale->Translate($i);

		if( $this->abswidth > -1 )
		    $abswidth=$this->abswidth;
		else
		    $abswidth=round($this->width*$xscale->scale_factor,0);
		
		$pts=array($xt,$accyt,$xt,$yt,$xt+$abswidth,$yt,$xt+$abswidth,$accyt);

		if( $this->bar_shadow ) {
		    $ssh = $this->bar_shadow_hsize;
		    $ssv = $this->bar_shadow_vsize;
		    
		    // We must also differ if we are a positive or negative bar. 
		    if( $j === 0 ) {
			// This gets extra complicated since we have to
			// see all plots to see if we are negative. It could
			// for example be that all plots are 0 until the very
			// last one. We therefore need to save the initial setup
			// for both the negative and positive case

			// In case the final bar is positive
			$sp[0]=$pts[6]+1; $sp[1]=$pts[7];
			$sp[2]=$pts[6]+$ssh; $sp[3]=$pts[7]-$ssv;

			// In case the final bar is negative
			$nsp[0]=$pts[0]; $nsp[1]=$pts[1];
			$nsp[2]=$pts[0]+$ssh; $nsp[3]=$pts[1]-$ssv;
			$nsp[4]=$pts[6]+$ssh; $nsp[5]=$pts[7]-$ssv;
			$nsp[10]=$pts[6]+1; $nsp[11]=$pts[7];
		    }

		    if( $j === $this->nbrplots-1 ) {
			// If this is the last plot of the bar and
			// the total value is larger than 0 then we
			// add the shadow.
			if( $accy > 0 ) {
			    $sp[4]=$pts[4]+$ssh; $sp[5]=$pts[5]-$ssv;
			    $sp[6]=$pts[2]+$ssh; $sp[7]=$pts[3]-$ssv;
			    $sp[8]=$pts[2]; $sp[9]=$pts[3]-1;
			    $sp[10]=$pts[4]+1; $sp[11]=$pts[5];
			    $img->PushColor($this->bar_shadow_color);
			    $img->FilledPolygon($sp,4);
			    $img->PopColor();
			}
			elseif( $accy_neg < 0 ) {
			    $nsp[6]=$pts[4]+$ssh; $nsp[7]=$pts[5]-$ssv;
			    $nsp[8]=$pts[4]+1; $nsp[9]=$pts[5];
			    $img->PushColor($this->bar_shadow_color);
			    $img->FilledPolygon($nsp,4);
			    $img->PopColor();
			}
		    }
		}

		// If value is NULL or 0, then don't draw a bar at all
		if ($this->plots[$j]->coords[0][$i] == 0 ) continue;

		if( $this->plots[$j]->grad ) {
		    $grad = new Gradient($img);
		    $grad->FilledRectangle(
			$pts[2],$pts[3],
			$pts[6],$pts[7],
			$this->plots[$j]->grad_fromcolor,
			$this->plots[$j]->grad_tocolor,
			$this->plots[$j]->grad_style);				
		} else {
		    if (is_array($this->plots[$j]->fill_color) ) {
			$numcolors = count($this->plots[$j]->fill_color);
			$img->SetColor($this->plots[$j]->fill_color[$i % $numcolors]);
		    }
		    else {
			$img->SetColor($this->plots[$j]->fill_color);
		    }
		    $img->FilledPolygon($pts);
		    $img->SetColor($this->plots[$j]->color);
		}				  


		// CSIM array

		if( $i < count($this->plots[$j]->csimtargets) ) {
		    // Create the client side image map
		    $rpts = $img->ArrRotate($pts);		
		    $csimcoord=round($rpts[0]).", ".round($rpts[1]);
		    for( $k=1; $k < 4; ++$k){
			$csimcoord .= ", ".round($rpts[2*$k]).", ".round($rpts[2*$k+1]);
		    }	    	    
		    if( ! empty($this->plots[$j]->csimtargets[$i]) ) {
			$this->csimareas.= '<area shape="poly" coords="'.$csimcoord.'" '; 
			$this->csimareas.= " href=\"".$this->plots[$j]->csimtargets[$i]."\"";
			if( !empty($this->plots[$j]->csimalts[$i]) ) {
			    $sval=sprintf($this->plots[$j]->csimalts[$i],$this->plots[$j]->coords[0][$i]);
			    $this->csimareas .= " alt=\"$sval\" title=\"$sval\" ";
			}
			$this->csimareas .= ">\n";				
		    }
		}

		$pts[] = $pts[0];
		$pts[] = $pts[1];
		$img->Polygon($pts);
	    }
		
	    // Draw labels for each acc.bar
	
	    $x=$pts[2]+($pts[4]-$pts[2])/2;
	    $y=$yscale->Translate($accy);			
	    if($this->bar_shadow) $x += $ssh;
	    $this->value->Stroke($img,$accy,$x,$y);

	    $accy = 0;
	    $accy_neg = 0; 
	    for($j=0; $j<$this->nbrplots; ++$j ) {				
		if ($this->plots[$j]->coords[0][$i] > 0) {
		    $yt=$yscale->Translate($this->plots[$j]->coords[0][$i]+$accy);
		    $accyt=$yscale->Translate($accy);
		    $y = $accyt-($accyt-$yt)/2;
		    $accy+=$this->plots[$j]->coords[0][$i];
		} else {
		    $yt=$yscale->Translate($this->plots[$j]->coords[0][$i]+$accy_neg);
		    $accyt=$yscale->Translate($accy_neg);
		    //$y=0;
		    $accy_neg+=$this->plots[$j]->coords[0][$i];
		    $y = $accyt-($accyt-$yt)/2; // TODO : Check this fix
		}	
		$this->plots[$j]->value->SetAlign("center","center");
		$this->plots[$j]->value->SetMargin(0);
		$this->plots[$j]->value->Stroke($img,$this->plots[$j]->coords[0][$i],$x,$y);
	    }

	}
	return true;
    }
} // Class

/* EOF */
?>
