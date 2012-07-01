<?php
	/**
	 *
	 * PHP 5
	 *
	 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
	 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 *
	 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
	 * @link          http://cakephp.org CakePHP(tm) Project
	 * @package       Cake.View.Layouts
	 * @since         CakePHP(tm) v 0.10.0.1076
	 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
	 */

	$cakeDescription = __d('cake_dev', 'Screen Bin');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo $cakeDescription ?>:
			<?php echo $title_for_layout; ?>
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php
			echo $this->Html->meta('icon');
			echo $this->Html->css('bootstrap.min.css');
			echo $this->Html->script('jquery-1.7.2.js');
			echo $this->Html->script('bootstrap.js');
			echo $this->Html->css('style');
			echo $this->Html->css('home');
			echo $this->Html->script('home');
			//echo $this->Html->script('mixpanel.js');
		?>
	</head>

	<body>
		<div id='page'> 
			<div id='header'>
				<div id='logo'>
					<a href='/'>ScreenBin</a>
				</div>
				<div id='slogan'>
					ShortURLs for Screenshots
				</div>
			</div>
			<div id='content'>
				<div id='screenshot-container'>
					<div id='screenshot-image'>
						<div id='instructions-container' class='overlay'>
							<div id='instructions-label'>
								Take a screenshot.</br>
								Paste.
							</div>
						</div>

						<div id='loading-status-container' class='overlay'>
							<!-- -->
						</div>
						
						<div id='url-container' class='overlay'>
							<div id='url-label'>
								<div id='screenshot-url'>Retrieving screenshot URL...</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id='footer'>
				<div id='about'>
					created by <a href='twitter.com/dennis_qian'>@dennis_qian</a>.
				</div>
			</div>
			<a href='https://github.com/dqian/screen-bin'>
				<img id='github' src='http://s3.amazonaws.com/github/ribbons/forkme_left_red_aa0000.png' alt='Fork me on Github'>
			</a>
		</div>
	</body>
</html>