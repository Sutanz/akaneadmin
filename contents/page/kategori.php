<?php
/*
 *
 * Admin Controller for table kategori
 * generated on 16 June 2017 05:35:02
 *
 *
 * This file is auto generated by Akane Console Tools
 * you can customize it to your need
 * for more information
 * type command "php console" from Akane directory on Terminal console
 * 
 */

$web->admin();
$web->set_heading('Kategori');

load_model('kategori');

if ( (isset($_GET['action'])) && (!empty($_GET['action'])) )
{
	$action = $_GET['action'];
} else {
	$action = '';
}
	switch($action)
	{
		case 'add':
			$web->breadcumbs->add('?content=kategori','Kategori');
			$web->breadcumbs->add('current','Add');

			echo BACKLINK;

			if ( (isset($_POST['ppost'])) && ($_POST['ppost']==MENU_ADD) )
			{
				if (!empty($_POST['name'])) {
					unset($_POST['ppost']);
					$_POST['action'] = 'insert';
					$_POST['table'] = 'kategori';


					$web->db->auto_save();
					$web->gotopage(THISFILE);

				} else { echo ERROR_NULL; }
			}


			$this->forms
			->form_header('Add Kategori')
				->add('name', 'text', array('required' => true))

			->renderForm(MENU_ADD);

		break;
		case 'edit':
			$web->breadcumbs->add('?content=kategori','Kategori');
			$web->breadcumbs->add('current','Change');

			echo BACKLINK;

			if ( (isset($_GET['idb'])) && (!empty($_GET['idb'])) )
			{
				$idb = $_GET['idb'];
				$data = $web->kategori->single($idb);
				$cb = count($data);
				if ($cb!=0)
				{
					$rb = $data[0];

					if ( (isset($_POST['ppost'])) && ($_POST['ppost']==MENU_EDIT) )
					{
						if (!empty($_POST['name'])) {
							unset($_POST['ppost']);
							$_POST['action'] = 'update';
							$_POST['table'] = 'kategori';
							$_POST['where'] = 'id='.$rb['id'];

							$web->db->auto_save();
							$web->gotopage(THISFILE);

						} else { echo ERROR_NULL; }
					}


					$this->forms
					->form_header('Change Kategori')
				->add('name', 'text', array('required' => true, 'value' => $rb['name']))

					->renderForm(MENU_EDIT);

				} else {
					echo ERROR_IDB_NULL;
				}
			} else {
				echo ERROR_IDB_NULL;
			}
		break;
		case 'delete':
			if ( (isset($_GET['idb'])) && (!empty($_GET['idb'])) )
			{
				$idb = $_GET['idb'];
				$data = $web->kategori->single($idb);
				$cb = count($data);
				if ($cb!=0)
				{
					$rb = $data[0];

					$delete = $web->db->query_delete('kategori',array('id' => $rb['id']));
					if ($delete){
						$web->gotopage(THISFILE);
					}
				} else {
					echo ERROR_IDB_NULL;
				}
			} else {
				echo ERROR_IDB_NULL;
			}
		break;
		case 'view':
			$web->breadcumbs->add('?content=kategori','Kategori');
			$web->breadcumbs->add('current','View');
			
			echo BACKLINK;

			if ( (isset($_GET['idb'])) && (!empty($_GET['idb'])) )
			{
				$idb = $_GET['idb'];
				$data = $web->kategori->single($idb);
				$cb = count($data);
				if ($cb!=0)
				{
					$rb = $data[0];
					$thead = array('id','name');
					$web->forms->renderView($thead, $rb);
				} else {
					echo ERROR_IDB_NULL;
				}
			} else {
				echo ERROR_IDB_NULL;
			}			
		break;
		default:
			$web->breadcumbs->add('current','Kategori');
			$web->forms->topbar();

			$keyword = '';
			$searchlink = '';
			if (isset($_GET['keyword'])){
				$keyword = $_GET['keyword'];
				$searchlink = '&keyword='.$_GET['keyword'];
			}
			
			$data = $web->kategori->all('',$keyword);
			$jmlrec = count($data);
			
			$url = SITEURL.'?content='.THISFILE.$searchlink.'&paged=[[paged]]';
            $paging = $web->pagination_seo($jmlrec, $url);
            
            $data = $web->kategori->all($paging['limit'],$keyword);
            $jmlr = count($data);
            
			if ($jmlrec>0)
			{
				$thead = array('id','name','action' => array('view','edit','delete'));
				$web->forms->renderTable($thead, $data);
				echo $paging['output'];
			} else {
				echo ERROR_EMPTY;
				echo "<br /><br />";
			}
		break;
	}

