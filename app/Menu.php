<?php

namespace App;

use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $table = "menus";
	public $timestamps = false;

	public function menuLinks()
	{
		return $this->hasMany("App\MenuLink", "menu_id");
	}

	public function links($menuType)
	{
		$parentLinks = $this->menuLinks()->where("parent_id", 0)->orderBy("sort_order", "asc")->get();

		if ($parentLinks != "") {
			foreach ($parentLinks as $parentLink) {
				$this->getHeadLinks($parentLink, $menuType);
			}
		}
	}

	function getHeadLinks($parent, $menuType)
	{
		$href1 = "#";
		$name1 = '';

		$liClass = 'nav-item';
		$aClass = 'nav-link';
		if ($menuType == "footer") {
			$liClass = '';
			$aClass = '';
		}
		$newWindow = "";
		$sub1 = 0;

		if (!empty($parent->menulink_trans(Session::get('locale'))))
			$name1 .= $parent->menulink_trans(Session::get('locale'))->name;
		else
			$name1 .= $parent->menulink_trans('en')->name;


		switch ($parent->link_type) {
			case "menu":
				$sub1 = 1;
				break;
			case "page":
				$settings = json_decode($parent->settings, true);
				$pageId = $settings["page_id"];
				$page = Page::find($pageId);
				$page_trans = $page->page_trans(Session::get('locale'));
				if (empty($page_trans))
					$page_trans = $page->page_trans("en");

				$slug = $page_trans->slug;
				$href1 = url(App('urlLang') . 'pages/' . $slug);
				if ($menuType == "header" && $slug = "about-us")
					$name1 = "<i class=\"fa fa-info\"></i>" . $name1;
				break;
			case "link":
				$settings = json_decode($parent->settings, true);
				$href1 = $settings["link"];
				break;
			case "mainPage":
				$href1 = url(App("urlLang"));
				break;
			case "contactPage":
				$href1 = url(App('urlLang') . 'contact');
				if ($menuType == "header")
					$name1 = '<i class="fa fa-envelope"></i>' . $name1;
				break;
			case "coursesPage":
				$href1 = url(App('urlLang'));
				break;
			case "booksPage":
				$href1 = url(App('urlLang') . 'books');
				break;
			case "graduatesPage":
				$href1 = url(App('urlLang') . 'graduates');
				break;
			case "faqPage":
				$href1 = url(App('urlLang') . 'faq');
				break;
			case "newsPage":
				$href1 = url(App('urlLang') . 'news');
				break;
		}

		$childs = $parent->childs()->orderBy("sort_order", "asc")->get();

		if ($parent->open_window) {
			$newWindow = 'target="_blank"';
		}

		if ($menuType == "child") {
			echo   '<a class="dropdown-item" href="' . $href1 . '" ' . $newWindow . '>';
			echo  $name1;
			echo '</a>';
			return;
		} else {
			if ($childs->isEmpty() && $parent->link_type != "coursesPage") {
				echo '<li class="' . $liClass . '">';
				echo   '<a class="' . $aClass . '" href="' . $href1 . '" ' . $newWindow . '>';
				echo  $name1;
				echo '</a>';
			} else {
				echo '<li class="nav-item dropdown">';
				echo   '<a class="nav-link dropdown-toggle" id="navbarDropdown" href="' . $href1 . '" ' . $newWindow;
				if ($href1 == "#")
					echo 'onClick="return false;"';
				echo ' role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';

				echo  $name1;
				echo '</a>';
			}
		}

		if (!$childs->isEmpty() || $parent->link_type == "coursesPage") {
			echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="text-align: justify">';
			if ($parent->link_type == "coursesPage") {
				$categories = \App\Category::get();
				echo   '<a class="dropdown-item" href="' . $href1 . '/all-courses" >';
				echo  trans('home.all_courses');
				echo '</a>';
				foreach ($categories as $category) {
					$category_trans = $category->category_trans(Session::get('locale'));
					if (empty($category_trans))
						$category_trans = $category->category_trans("en");
					echo   '<a class="dropdown-item" href="' . $href1 . '/' . $category_trans->slug . '" >';
					echo  $category_trans->name;
					echo '</a>';
				}
			} else {
				foreach ($childs as $child) {
					echo $this->getHeadLinks($child, "child");
				}
			}
			echo "</div>";
		}
		echo "</li>";
	}
}
