<?php
/**
 * @version $Id$
 * KunenaLatest Module
 * @package Kunena latest
 *
 * @Copyright (C) 2010 www.kunena.com All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.com
 */

// no direct access
defined ( '_JEXEC' ) or die ( '' );

$params = (object) $params;

$document = & JFactory::getDocument ();
$document->addStyleSheet ( JURI::root () . 'modules/mod_kunenalatest/tmpl/kunenalatest.css' );
?>
<div class="klatest<?php echo $params->get ( 'moduleclass_sfx' )?>">

<?php
//print_r($klistpost);
$config = & JFactory::getConfig ();
$tzoffset = $config->getValue ( 'config.offset' );

//vérifier que $klistpost n'est pas vide


if (is_array ( $klistpost )) {
	foreach ( $klistpost as $item ) {
		//construct the date
		$date = JFactory::getDate ( $item->time, $tzoffset );
		$date = $date->toFormat ( $params->get ( 'dateformat' ) );

		?>
	<div>
	<?php
		if ($params->get ( 'sh_avatar' )) {
			$kprofile = KunenaFactory::getUser($item->userid);
			echo CKunenaLink::GetProfileLink ($item->userid, $kprofile->getAvatarLink () );
		}
		if ($params->get ( 'sh_rank' )) {
			if (! empty ( $item->posts )) {
				?>
	<div><?php echo JText::_ ( 'MOD_KUNENALATEST_USER_POSTS' ); ?>&nbsp; <?php echo $item->posts; ?></div>
	<?php
			}
		}
		?>
	</div>
<div id="klatestnav">
<ul>
	<li>
	<?php
		if ($params->get ( 'sh_sticky' )) {
			if ($item->ordering) {
				echo '<img src="' . JURI::root () . 'modules/mod_kunenalatest/tmpl/sticky.png" alt="' . JText::_ ( 'MOD_KUNENALATEST_STICKY_TOPIC' ) . '" title="' . JText::_ ( 'MOD_KUNENALATEST_STICKY_TOPIC' ) . '" />';
			}
		}
		echo CKunenaLink::GetThreadLink ( 'view', $item->catid, $item->id, substr ( htmlspecialchars ( stripslashes ( $item->subject ) ), '0', $params->get ( 'titlelength' ) ), substr ( htmlspecialchars ( stripslashes ( $item->messagetext ) ), '0', $params->get ( 'messagelength' ) ), 'follow' );
		if ($item->unread) {
			echo $params->get ( 'unreadindicator' );
		}
		if ($params->get ( 'sh_favorite' )) {
			if ($item->favcount) {
				if ($item->myfavorite) {
					echo '<img class="favoritestar" src="' . KUNENA_URLICONSPATH . 'favoritestar.png"  alt="' . JText::_ ( 'MOD_KUNENALATEST_FAVORITE' ) . '" title="' . JText::_ ( 'MOD_KUNENALATEST_FAVORITE' ) . '" />';
				} else {
					echo '<img class="favoritestar-grey" src="' . KUNENA_URLICONSPATH . 'favoritestar-grey.png"  alt="' . JText::_ ( 'MOD_KUNENALATEST_FAVORITE' ) . '" title="' . JText::_ ( 'MOD_KUNENALATEST_FAVORITE' ) . '" />';
				}
			}
		}
		if ($params->get ( 'sh_locked' )) {
			if ($item->locked) {
				echo '<img src="' . KUNENA_URLICONSPATH . 'lock_sm.png"  alt="' . JText::_ ( 'MOD_KUNENALATEST_LOCKED_TOPIC' ) . '" title="' . JText::_ ( 'MOD_KUNENALATEST_GEN_LOCKED_TOPIC' ) . '" />';
			}
		}
		?></li>
	<li>
	<?php echo JText::_ ( 'MOD_KUNENALATEST_POSTED_AT' ); ?> <?php echo $date; ?></li>
	<li><?php echo CKunenaLink::GetCategoryLink ( 'showcat', $item->catid, $item->catname ); ?></li>
	<li><?php
		if (! $params->get ( 'sh_avatar' )) {
			echo JText::_ ( 'MOD_KUNENALATEST_LAST_POST_BY' ) .' '. CKunenaLink::GetProfileLink ( $item->userid, $item->name );
		}
		?></li>
</ul>
</div>
<?php
	} //end foreach
}
?><br />
<?php echo CKunenaLink::GetShowLatestLink ( JText::_ ( 'MOD_KUNENALATEST_MORE_LINK' ) ); ?>
</div>