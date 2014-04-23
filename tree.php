<?php

error_reporting(E_ALL);
/*
	NOTES:

	* PATHS need to be adjusted to touch the center of spheres.
	** AFTER some work, this PATHS $top OFFSET still looks like in need of some more work and mathematics.

	* WORDS need to be corrected in CSS with sphere's border when border begin to be calculated by PHP class.

	* I can do a SETLONGWORDS, that is a text that comes like a TOPWORDS, but when it reaches an angle of 360o
	** it passes to the inside line, but it need a trigonometric calculation so that when it passes to the next (inner to
	** the sphere) line, it keeps the same line-spacing.

	* To gain control on the text on PATHS (and you should do a SETLONGTEXTTOPATH()) you just put inside the PATH DIV a
	** CENTERED DIV with LESS THE SPHERE_RADIUS on each side.

*/

class HandleHTMLandCSS
{
	public $css;
	public $html;

	public $spheres_data;
	public $paths_data;
	public $paths_labels_data;
	public $topwords_data;
	public $middlewords_data;
	public $bottomwords_data;

	public $number_of_spheres;
	public $number_of_paths;
	public $number_of_topwords;
	public $number_of_middlewords;
	public $number_of_bottomwords;

	public $frame_width;
	public $frame_height;

	public $sphere_width;
	public $sphere_height;

	public $path_height;
	public $path_line_height;

	public $middleword_width;
	public $middleword_height;

	public $topword_letter_height;
	public $bottomword_letter_height;

	public function __construct($frame_width, $frame_height)
	{
		$this->frame_width = $frame_width;
		$this->frame_height = $frame_height;

		$this->number_of_spheres = 11;
		$this->number_of_paths = 22;
		$this->number_of_paths_labels = 22;
		$this->number_of_topwords = 11;
		$this->number_of_middlewords = 11;
		$this->number_of_bottomwords = 11;
	}

	public function setSphere($sphere, $width, $height, $top, $position)
	{
		$this->sphere_width = $width;
		$this->sphere_height = $height;

		$this->spheres_data["{$sphere}"]['css'] =<<<EOT
.sphere-{$sphere}
{
	top: {$top}px;
	{$position}
}

EOT;

		$this->spheres_data["{$sphere}"]['html'] =<<<EOT
<div class="sphere-{$sphere} spheres-commom sphere-aux-{$sphere} spheres"></div>

EOT;
	}

	public function setPath($path, $width, $height, $rotate, $top, $position)
	{
		$path_label = (isset($this->paths_labels_data["{$path}"]['label']) ? ($this->paths_labels_data["{$path}"]['label']) : "");

		$this->path_height = $height;
		$this->path_line_height = $height;

		$this->paths_data["{$path}"]['css'] = <<<EOT
.path-{$path}
{
	width: {$width}px;

	-webkit-transform: rotate({$rotate}deg);
	-moz-transform: rotate({$rotate}deg);
	-o-transform: rotate({$rotate}deg);
	transform: rotate({$rotate}deg);

	top: {$top}px;
	{$position}
}

EOT;

		$this->paths_data["{$path}"]['html'] = <<<EOT
<div class="path-{$path} paths-commom paths">{$path_label}</div>

EOT;
	}

	public function setPathLabel($path, $label)
	{
		$this->paths_labels_data["{$path}"]['label'] = $label;
	}

	public function setTopWord($sphere, $letter_num, $height, $top, $position, $rotate, $letter)
	{
		$this->topword_letter_height = $height;
		$this->topwords_data["{$sphere}"]['css'] .= <<<EOT
.word-letter-{$sphere}-{$letter_num}
{
	top: {$top}
	{$position}

	-webkit-transform: rotate({$rotate}deg);
	-webkit-transform-origin: bottom center;
	-moz-transform: rotate({$rotate}deg);
	-moz-transform-origin: bottom center;
	-o-transform: rotate({$rotate}deg);
	-o-transform-origin: bottom center;
	transform: rotate({$rotate}deg);
	transform-origin: bottom center;
}

EOT;

		$this->topwords_data["{$sphere}"]['html'] .= "<div class=\"word-letter-{$sphere}-{$letter_num} topword-letters-commom sphere-aux-{$sphere} top-words words\">{$letter}</div>\n";
	}

	public function setMiddleWord($sphere, $word, $width, $height, $top, $position)
	{
		$this->middleword_width = $width;
		$this->middleword_height = $height;

		$this->middlewords_data["{$sphere}"]['css'] .= <<<EOT
.middle-word-{$sphere}
{
	top: {$top}
	{$position}
}

EOT;

		$this->middlewords_data["{$sphere}"]['html'] .= "<div class=\"middle-word-{$sphere} middle-words-commom sphere-aux-{$sphere} middle-words words\">{$word}</div>\n";
	}

	public function setBottomWord($sphere, $letter_num, $height, $top, $position, $rotate, $letter)
	{
		$this->bottomword_letter_height = $height;
		$this->bottomwords_data["{$sphere}"]['css'] .= <<<EOT
.bottomword-letter-{$sphere}-{$letter_num}
{
	top: {$top}
	{$position}

	-webkit-transform: rotate({$rotate}deg);
	-webkit-transform-origin: top center;
	-moz-transform: rotate({$rotate}deg);
	-moz-transform-origin: top center;
	-o-transform: rotate({$rotate}deg);
	-o-transform-origin: top center;
	transform: rotate({$rotate}deg);
	transform-origin: top center;

}

EOT;

		$this->bottomwords_data["{$sphere}"]['html'] .= "<div class=\"bottomword-letter-{$sphere}-{$letter_num} bottomword-letters-commom sphere-aux-{$sphere} bottom-words words\"><div style=\"position:absolute;bottom:0;\">{$letter}</div></div>\n";
	}

	public function generateCss()
	{
		$spheres_css = "";
		$paths_css = "";
		$topwords_css = "";
		$middlewords_css = "";
		$bottomwords_css = "";

		for($i=1; $i<=$this->number_of_spheres; $i++)
			$spheres_css .= $this->spheres_data["{$i}"]['css'];

		for($i=1; $i<=$this->number_of_paths; $i++)			
			$paths_css .= $this->paths_data["{$i}"]['css'];

		for($i=1; $i<=$this->number_of_topwords; $i++)			
			$topwords_css .= isset($this->topwords_data["{$i}"]['css']) ? $this->topwords_data["{$i}"]['css'] : "";

		for($i=1; $i<=$this->number_of_middlewords; $i++)			
			$middlewords_css .= isset($this->middlewords_data["{$i}"]['css']) ? $this->middlewords_data["{$i}"]['css'] : "";

		for($i=1; $i<=$this->number_of_bottomwords; $i++)			
			$bottomwords_css .= isset($this->bottomwords_data["{$i}"]['css']) ? $this->bottomwords_data["{$i}"]['css'] : "";

		$this->css=<<<EOT
<style>
.frame
{
	width: {$this->frame_width}px;
	min-height: {$this->frame_height}px;
	margin: 10px;
	border: 1px solid #ccc;
	position: relative;

	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	-ms-box-sizing:border-box;
	box-sizing:border-box;
}

.spheres-commom
{
	width: {$this->sphere_width}px;
	height: {$this->sphere_height}px;

	text-align: center;
	border-radius: 100%;
	border: 1px solid #333;

	position: absolute;

	background-color: #fff;
	z-index: 1;

	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	-ms-box-sizing:border-box;
	box-sizing:border-box;
}

.paths-commom
{
	height: {$this->path_height}px;
	line-height: {$this->path_line_height}px;
	border: 1px solid #333;

	position: absolute;

	text-align: center;
	vertical-align: middle;

	background-color: #fff;

	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	-ms-box-sizing:border-box;
	box-sizing:border-box;
}

.middle-words-commom
{
	width: {$this->middleword_width}px;
	height: {$this->middleword_height}px;

	position: absolute;

	z-index: 3;

	text-align: center;

	font-size: {$this->middleword_height}px;
}

.topword-letters-commom
{
	height: {$this->topword_letter_height}px;

	position: absolute;
	z-index: 2;
	width: 0px;

	font-family: monospace;
}

.bottomword-letters-commom
{
	height: {$this->bottomword_letter_height}px;

	position: absolute;
	z-index: 2;
	width: 0px;

	font-family: monospace;
}

{$spheres_css}
{$paths_css}
{$middlewords_css}
{$topwords_css}
{$bottomwords_css}
</style>

EOT;
	}

	public function generateHtml()
	{
		$spheres_html = "";
		$paths_html = "";
		$topwords_html = "";
		$middlewords_html = "";
		$bottomwords_html = "";

		for($i=1; $i<=$this->number_of_spheres; $i++)
			$spheres_html .= $this->spheres_data["{$i}"]['html'];

		for($i=1; $i<=$this->number_of_paths; $i++)
			$paths_html .= $this->paths_data["{$i}"]['html'];

		for($i=1; $i<=$this->number_of_topwords; $i++)
			$topwords_html .= isset($this->topwords_data["{$i}"]['html']) ? $this->topwords_data["{$i}"]['html'] : "";

		for($i=1; $i<=$this->number_of_middlewords; $i++)
			$middlewords_html .= isset($this->middlewords_data["{$i}"]['html']) ? $this->middlewords_data["{$i}"]['html'] : "";

		for($i=1; $i<=$this->number_of_bottomwords; $i++)
			$bottomwords_html .= isset($this->bottomwords_data["{$i}"]['html']) ? $this->bottomwords_data["{$i}"]['html'] : "";

		$this->html=<<<EOT
<div class="frame">
{$spheres_html}
{$paths_html}
{$middlewords_html}
{$topwords_html}
{$bottomwords_html}
</div>

EOT;
	}
}

class TreeOfLife
{
	public $frame_width;
	public $frame_height;
	public $math_frame_width; // this is the frame from the cental point of the spheres

	public $frame_center;
	public $math_frame_center;

	public $degree; // SET THIS TO 30 IN THE CONSTRUCTOR TO HAVE A SOLID TREE OF LIFE

	public $sphere_diameter;
	public $sphere_radius;

	public $path_height;

	public $spheres;
	public $paths;

	public $word_margin;
	public $middle_word_margin;

	public $top_word_degree;
	public $bottom_word_degree;

	public $line_height;

	public $htmlandcss;

	public function __construct($frame_width = 650)
	{
		$this->frame_width = $frame_width;
		$this->frame_center = $this->frame_width / 2;
		$this->sphere_diameter = $this->frame_width * 0.234375; // (3/12.8)
		$this->sphere_radius = $this->sphere_diameter / 2;

		$this->path_height = $this->frame_width * 0.0546875;

		$this->math_frame_width = $this->frame_width - ($this->sphere_radius * 2);
		$this->math_frame_center = $this->math_frame_width / 2;

		$this->degree = 30;
		$this->line_height = $this->getOpposite($this->degree, $this->math_frame_center);

		$this->frame_height = ($this->line_height * 9)+9;

		$this->word_margin = $this->sphere_radius * 0.114754;

		$this->top_word_degree = 10;
		$this->bottom_word_degree = $this->top_word_degree;

		$this->middle_word_width = $this->sphere_diameter;
		$this->middle_word_height = $this->sphere_radius * 0.4;

		$this->htmlandcss = new HandleHTMLandCSS($this->frame_width, $this->frame_height);

		$this->spheres = array(
			'1' => array('line'=>1, 'column'=>'center'),
			'2' => array('line'=>2, 'column'=>'right'),
			'3' => array('line'=>2, 'column'=>'left'),
			'4' => array('line'=>4, 'column'=>'right'),
			'5' => array('line'=>4, 'column'=>'left'),
			'6' => array('line'=>5, 'column'=>'center'),
			'7' => array('line'=>6, 'column'=>'right'),
			'8' => array('line'=>6, 'column'=>'left'),
			'9' => array('line'=>7, 'column'=>'center'),
			'10' => array('line'=>9, 'column'=>'center'), // this ~corrects it
			'11' => array('line'=>3, 'column'=>'center')
		);

		$this->paths = array(
			'1' => array('link_1'=>1, 'link_2'=>2, 'place'=>'right', 'rotate'=>'cw'),
			'2' => array('link_1'=>1, 'link_2'=>3, 'place'=>'left', 'rotate'=>'ccw'),
			'3' => array('link_1'=>1, 'link_2'=>6, 'place'=>'center', 'rotate'=>'cw'),
			'4' => array('link_1'=>2, 'link_2'=>3, 'place'=>'center', 'rotate'=>'none'),
			'5' => array('link_1'=>2, 'link_2'=>6, 'place'=>'right', 'rotate'=>'ccw'),
			'6' => array('link_1'=>2, 'link_2'=>4, 'place'=>'right', 'rotate'=>'cw'),
			'7' => array('link_1'=>3, 'link_2'=>6, 'place'=>'left', 'rotate'=>'cw'),
			'8' => array('link_1'=>3, 'link_2'=>5, 'place'=>'left', 'rotate'=>'cw'),
			'9' => array('link_1'=>4, 'link_2'=>5, 'place'=>'center', 'rotate'=>'none'),
			'10' => array('link_1'=>4, 'link_2'=>6, 'place'=>'right', 'rotate'=>'ccw'),
			'11' => array('link_1'=>4, 'link_2'=>7, 'place'=>'right', 'rotate'=>'cw'),
			'12' => array('link_1'=>5, 'link_2'=>6, 'place'=>'left', 'rotate'=>'cw'),
			'13' => array('link_1'=>5, 'link_2'=>8, 'place'=>'left', 'rotate'=>'cw'),
			'14' => array('link_1'=>6, 'link_2'=>7, 'place'=>'right', 'rotate'=>'cw'),
			'15' => array('link_1'=>6, 'link_2'=>9, 'place'=>'center', 'rotate'=>'cw'),
			'16' => array('link_1'=>6, 'link_2'=>8, 'place'=>'left', 'rotate'=>'ccw'),
			'17' => array('link_1'=>7, 'link_2'=>8, 'place'=>'center', 'rotate'=>'none'),
			'18' => array('link_1'=>7, 'link_2'=>9, 'place'=>'right', 'rotate'=>'ccw'),
			'19' => array('link_1'=>7, 'link_2'=>10, 'place'=>'right', 'rotate'=>'ccw'),
			'20' => array('link_1'=>8, 'link_2'=>9, 'place'=>'left', 'rotate'=>'cw'),
			'21' => array('link_1'=>8, 'link_2'=>10, 'place'=>'left', 'rotate'=>'cw'),
			'22' => array('link_1'=>9, 'link_2'=>10, 'place'=>'center', 'rotate'=>'cw')
		);

		$this->calcSpheres();

		$this->setPathLabel(1, "0 &sdot; O Louco");
		$this->setPathLabel(2, "I &sdot; O Magus");
		$this->setPathLabel(3, "II &sdot; A Sacerdotisa");
		$this->setPathLabel(4, "III &sdot; A Imperatriz");
		$this->setPathLabel(5, "IV &sdot; O Imperador");
		$this->setPathLabel(6, "V &sdot; O Hierofante");
		$this->setPathLabel(7, "VI &sdot; Os Amantes");
		$this->setPathLabel(8, "VII &sdot; O Veiculo");
		$this->setPathLabel(9, "VIII &sdot; O Equilibrio");
		$this->setPathLabel(10, "IX &sdot; O Eremita");
		$this->setPathLabel(11, "X &sdot; A Roda");
		$this->setPathLabel(12, "XI &sdot; A Luxuria");
		$this->setPathLabel(13, "XII &sdot; O Pendurado");
		$this->setPathLabel(14, "XIII &sdot; A Morte");
		$this->setPathLabel(15, "XIV &sdot; A Arte");
		$this->setPathLabel(16, "XV &sdot; O Diabo");
		$this->setPathLabel(17, "XVI &sdot; A Torre");
		$this->setPathLabel(18, "XVII &sdot; A Estrela");
		$this->setPathLabel(19, "XVIII &sdot; A Lua");
		$this->setPathLabel(20, "XIX &sdot; O Sol");
		$this->setPathLabel(21, "XX &sdot; O Aeon");
		$this->setPathLabel(22, "XXI &sdot; O Universo");

		$this->calcPaths();

		$this->setTopWord(1, "Kether - Corona");
		$this->setTopWord(2, "Chokmah - Sapientia");
		$this->setTopWord(3, "Binah - Comprehensio");
		$this->setTopWord(4, "Chesed - Clementia");
		$this->setTopWord(5, "Geburah - Virtus");
		$this->setTopWord(6, "Tiphareth - Pulchritudo");
		$this->setTopWord(7, "Netzach - Victoria");
		$this->setTopWord(8, "Hod - Splendor");
		$this->setTopWord(9, "Yesod - Fundamentum");
		$this->setTopWord(10, "Malkuth - Regnum");
		$this->setTopWord(11, "Daath - Scientia");

		$this->setMiddleWord(1, "1");
		$this->setMiddleWord(2, "2");
		$this->setMiddleWord(3, "3");
		$this->setMiddleWord(4, "4");
		$this->setMiddleWord(5, "5");
		$this->setMiddleWord(6, "6");
		$this->setMiddleWord(7, "7");
		$this->setMiddleWord(8, "8");
		$this->setMiddleWord(9, "9");
		$this->setMiddleWord(10, "10");
		$this->setMiddleWord(11, "11");

		$this->setBottomWord(1, "Coroa");
		$this->setBottomWord(2, "Sabedoria");
		$this->setBottomWord(3, "Compreensao");
		$this->setBottomWord(4, "Misericordia");
		$this->setBottomWord(5, "Forca");
		$this->setBottomWord(6, "Beleza");
		$this->setBottomWord(7, "Vitoria");
		$this->setBottomWord(8, "Esplendor");
		$this->setBottomWord(9, "Fundamento");
		$this->setBottomWord(10, "Reino");
		$this->setBottomWord(11, "Conhecimento");

		$this->generateCSSandHTML();
	}

	public function calcSpheres($num_of_spheres = 11)
	{
		for($i=1; $i<=$num_of_spheres; $i++)
		{
			$top = (($this->spheres["{$i}"]['line']-1) * $this->line_height);

			switch($this->spheres["{$i}"]['column'])
			{
				case "center":
					$position="left: " . ($this->frame_center - $this->sphere_radius) . "px;";
				break;

				case "right":
					$position="right: 0px;";
				break;

				case "left":
					$position="left: 0px;";
				break;
			}

			$this->htmlandcss->setSphere($i, $this->sphere_diameter, $this->sphere_diameter, $top, $position);
		}
	}

	public function calcPaths($num_of_paths = 22)
	{
		$height = $this->path_height;

		for($i=1; $i<=$num_of_paths; $i++)
		{
			$rotate=0;
			$position_algo=0;

			$line_distance = $this->spheres[ $this->paths["{$i}"]['link_2'] ]['line'] - $this->spheres[ $this->paths["{$i}"]['link_1'] ]['line'];

			// if $line_distance_center==0, $top is the height of the spheres; else, is the height of the half of the spheres
			$line_distance_center =	(($this->spheres[ $this->paths["{$i}"]['link_2'] ]['line'] + $this->spheres[ $this->paths["{$i}"]['link_1'] ]['line'])/2);

			$same_pillar = ( (strcmp($this->spheres[ $this->paths["{$i}"]['link_2'] ]['column'], $this->spheres[ $this->paths["{$i}"]['link_1'] ]['column'])===0) ?	true : false );

			switch($this->paths["{$i}"]['rotate'])
			{
				case "cw":
					if( $line_distance==1 ) { $rotate=$this->degree*1; $width = $this->getHypotenuse($rotate, $this->math_frame_center); }
					else if( $line_distance==2 ) { $rotate="90"; $width = $line_distance*$this->line_height; }
					else if( $line_distance==3 ) { $rotate=$this->degree*2; $width = $this->getHypotenuse($rotate, $this->math_frame_center); }
					else if( $line_distance==4 ) { $rotate="90"; $width = $line_distance*$this->line_height; } // 3rd path!
				break;

				case "ccw":
					if( $line_distance==1 ) { $rotate=-($this->degree*1); $width = $this->getHypotenuse($rotate, $this->math_frame_center); }
					else if( $line_distance==3 ) { $rotate=-($this->degree*2); $width = $this->getHypotenuse($rotate, $this->math_frame_center); }
				break;

				case "none":
					$rotate = "0";
					$width = $this->math_frame_width;
				break;
			}

			switch($this->paths["{$i}"]['place'])
			{
				case "right":
					$position_algo = ( ($same_pillar) ? ((-$width/2)+$this->sphere_radius) : ($this->sphere_radius-(($width/2)-($this->math_frame_center/2))) );
					$position = "right: {$position_algo}px;";
				break;

				case "left":
					$position_algo = ( ($same_pillar) ? ((-$width/2)+$this->sphere_radius) : ($this->sphere_radius-(($width/2)-($this->math_frame_center/2))) );
					$position = "left: {$position_algo}px;";
				break;

				case "center":
					if(strcmp($this->paths["{$i}"]['rotate'], "none")!==0) $position_algo = $this->frame_center - ($width/2);
					else $position_algo = $this->sphere_radius;

					$position = "left: {$position_algo}px;";
				break;
			}
			//$top = (($line_distance_center * $this->line_height) - ($this->sphere_radius)); -- THIS WAS THE ORIGINAL, BUT NEEDS SOME MORE WORK
			$top = ((($line_distance_center * $this->line_height)-($this->line_height/2))-$this->path_height/2);
			$this->htmlandcss->setPath($i, $width, $height, $rotate, $top, $position);
		}

	}

	public function setPathLabel($path, $label)
	{
		$this->htmlandcss->setPathLabel($path, $label);
	}

	public function setTopWord($sphere, $word)
	{
		$this->htmlandcss->topwords_data["{$sphere}"]['css'] = "";
		$this->htmlandcss->topwords_data["{$sphere}"]['html'] = "";

		$word_length = strlen($word);

		$top = ((($this->spheres["{$sphere}"]['line']-1) * $this->line_height) + $this->word_margin)."px;";

		if(strcmp($this->spheres["{$sphere}"]['column'], "center")===0) { $position="left: {$this->frame_center}px;"; }
		else if(strcmp($this->spheres["{$sphere}"]['column'], "right")===0) { $position="right: {$this->sphere_radius}px;"; }
		else if(strcmp($this->spheres["{$sphere}"]['column'], "left")===0) { $position="left: {$this->sphere_radius}px;"; }
		else { $position=""; }

		$rotate = 0;

		$degree = $this->top_word_degree;
		$shifting = $degree / 2;

		$height = $this->sphere_radius - $this->word_margin;

		$is_even = (($word_length % 2) === 0) ? true : false;

		$rotation_offset = ($is_even) ? ($shifting) : 0;

		$how_many_to_left = ($is_even) ? ($word_length/2) : (($word_length-1)/2);

		$rotation_begin = ($is_even) ? ($rotation_offset - ($degree * $how_many_to_left)) : (-($degree * $how_many_to_left)) ;
		

		for($i=0; $i<$word_length; $i++)
		{
			$rotate = ($rotation_begin + ($i * $degree)) ;
			$this->htmlandcss->setTopWord($sphere, $i, $height, $top, $position, $rotate, $word[$i]);
		}
	}

	public function setMiddleWord($sphere, $word)
	{

		$this->htmlandcss->middlewords_data["{$sphere}"]['css'] = "";
		$this->htmlandcss->middlewords_data["{$sphere}"]['html'] = "";

		$top = (((($this->spheres["{$sphere}"]['line']-1) * $this->line_height)+$this->sphere_radius)-$this->middle_word_height/2)."px;";

		switch($this->spheres["{$sphere}"]['column'])
		{
			case "center":
				$position="left: " . ($this->frame_center - $this->sphere_radius) . "px;";
			break;

			case "right":
				$position="right: 0px;";
			break;

			case "left":
				$position="left: 0px;";
			break;
		}

		$this->htmlandcss->setMiddleWord($sphere, $word, $this->middle_word_width, $this->middle_word_height, $top, $position);
	}

	public function setBottomWord($sphere, $word)
	{
		$this->htmlandcss->bottomwords_data["{$sphere}"]['css'] = "";
		$this->htmlandcss->bottomwords_data["{$sphere}"]['html'] = "";

		$word_length = strlen($word);

		$top = ((($this->spheres["{$sphere}"]['line']-1) * $this->line_height) + $this->sphere_radius)."px;";

		if(strcmp($this->spheres["{$sphere}"]['column'], "center")===0) { $position="left: {$this->frame_center}px;"; }
		else if(strcmp($this->spheres["{$sphere}"]['column'], "right")===0) { $position="right: {$this->sphere_radius}px;"; }
		else if(strcmp($this->spheres["{$sphere}"]['column'], "left")===0) { $position="left: {$this->sphere_radius}px;"; }
		else { $position=""; }

		$rotate = 0;

		$degree = $this->bottom_word_degree;
		$shifting = $degree / 2;

		$height = $this->sphere_radius - $this->word_margin;

		$is_even = (($word_length % 2) === 0) ? true : false;

		$rotation_offset = ($is_even) ? ($shifting) : 0;

		$how_many_to_left = ($is_even) ? ($word_length/2) : (($word_length-1)/2);

		$rotation_begin = ($is_even) ? (($degree * $how_many_to_left) - $rotation_offset) : (($degree * $how_many_to_left)) ;

		for($i=0; $i<$word_length; $i++)
		{
			$rotate = ($rotation_begin + ($i * -$degree)) ;
			$this->htmlandcss->setBottomWord($sphere, $i, $height, $top, $position, $rotate, $word[$i]);
		}
	}

	public function getOpposite($radius, $adjacent)
	{
		$tangent = tan(deg2rad($radius));
		$opposite = ($adjacent * $tangent);

		return $opposite;
	}

	public function getHypotenuse($radius, $adjacent)
	{
		$cos = cos(deg2rad($radius));
		$hypotenuse = $adjacent / $cos;

		return $hypotenuse;
	}

	public function generateCSSandHTML()
	{
		$this->htmlandcss->generateCss();
		$this->htmlandcss->generateHtml();
	}

	public function debug()
	{
		return <<<EOT
<div>math_frame_width: {$this->math_frame_width}</div>
<div>math_frame_center: {$this->math_frame_center}</div>
<div>sphere_diameter: {$this->sphere_diameter}</div>
<div>sphere_radius: {$this->sphere_radius}</div>
<div>line_height: {$this->line_height}</div>
EOT;
	}
}
?>
