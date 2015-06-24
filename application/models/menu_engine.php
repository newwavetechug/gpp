<?php
#Used to format menu displays
class Menu_engine extends CI_Model{

	var $menu_level = 0;
	
	#Constructor
	function Menu_engine()
	{
		parent::__construct();
		$this->load->database();
	}

    function menu_crumbs($current = '')
    {
        $crumb_str = '';
        $menu_bucket = $this->menu_bucket();

        if (!empty($current)) {
            $menu_parent = $this->find_my_parent($current);
            #exit($menu_parent);
            if (!empty($menu_parent)) {
                $crumb_str = '<li><a href="' . $menu_bucket[$menu_parent]['attr']['url'] . '">' . $menu_bucket[$menu_parent]['attr']['text'] . '</a>' .
                    '<span class="divider">&nbsp;</span>' .
                    '</li>' .
                    '<li><a href="' . $menu_bucket[$menu_parent]['child'][$current]['url'] . '">' . $menu_bucket[$menu_parent]['child'][$current]['text'] . '</a>' .
                    '<span class="divider-last">&nbsp;</span>' .
                    '</li>';
            } elseif (!empty($menu_bucket[$current])) {
                $crumb_str = '<li><a href="' . $menu_bucket[$current]['attr']['url'] . '">' . $menu_bucket[$current]['attr']['text'] . '</a>' .
                    '<span class="divider-last">&nbsp;</span>' .
                    '</li>';
            }
        }

        return $crumb_str;
    }
	
	function menu_bucket ()
	{
		#Dashboard
		$menu_array['dashboard']['attr'] = array('text'=>'Dashboard', 'url'=>base_url() . 'user/dashboard', 'id'=>'menu-dashboard', 'classes'=>'icon-dashboard');
        #Settings
        $menu_array['userinformation']['child']['home'] = array('text' => 'My Dashboard', 'url' => base_url() . 'user/dashboard', 'id' => 'menu-add-user', 'classes' => '');
        $menu_array['userinformation']['attr'] = array('text' => 'My Information', 'url' => 'javascript:void(0);', 'id' => 'user-information', 'classes' => 'fa fa-cog');
        $menu_array['userinformation']['child']['my_profile'] = array('text' => 'My Profile', 'url' => base_url() . 'user/profile_form', 'id' => 'my_profile', 'classes' => '');
        $menu_array['userinformation']['child']['log_out'] = array('text' => 'Log Out', 'url' => base_url() . '	admin/logout', 'id' => 'menu-add-user', 'classes' => '');


		#Procurement
        $menu_array['procurement']['attr'] = array('text'=>'Procurement', 'url'=>'javascript:void(0);', 'id'=>'menu_manage_procurement', 'classes'=>'fa fa-arrow-down');
        $menu_array['procurement']['child']['create_procurement_plan'] = array('text' => 'New Annual Procurement  Plan', 'url' => base_url() . 'procurement/procurement_plan_form', 'id' => 'new_plans', 'classes' => '');
        $menu_array['procurement']['child']['view_procurement_plans'] = array('text' => 'All Annual Procurement Plans', 'url' => base_url() . 'procurement', 'id' => 'all_plans', 'classes' => '');
        /*	$menu_array['procurement']['child']['initiate_procurement'] = array('text'=>'Initiate Procurement', 'url'=>base_url() . 'procurement/load_initiate_procurement_form', 'id'=>'initiate-procurement', 'classes'=>'');*/


        #bids under procur
        //$menu_array['procurement']['attr'] = array('text'=>'Bids', 'url'=>'javascript:void(0);', 'id'=>'menu-bids', 'classes'=>'icon-cogs');
        $menu_array['procurement']['child']['create_invitation_for_bids'] = array('text' => 'New Bid Invitation', 'url' => base_url() . 'bids/load_bid_invitation_form', 'id' => 'menu-add-bid-invitation', 'classes' => '');
        $menu_array['procurement']['child']['view_bid_invitations'] = array('text' => 'All Bid Invitations', 'url' => base_url() . 'bids/manage_bid_invitations', 'id' => 'menu-manage-bid-invitations', 'classes' => '');
        
        $menu_array['procurement']['child']['select_beb'] = array('text' => 'New Best Evaluated Bidder', 'url' => base_url() . 'bids/publish_bidder/active_procurements', 'id' => 'menu-publish-bidder', 'classes' => '');
        $menu_array['procurement']['child']['manage_bebs'] = array('text' => 'All Best Evaluated Bidders', 'url' => base_url() . 'receipts/manage_bebs', 'id' => 'menu-manage-receipts', 'classes' => '');

        #disposal
        $menu_array['disposal']['attr'] = array('text' => 'Disposal', 'url' => 'javascript:void(0);', 'id' => 'menu-disposal', 'classes' => 'fa fa-arrow-up');
        $menu_array['disposal']['child']['create_disposal_plan'] = array('text' => 'New  Disposal Plan ', 'url' => base_url() . 'disposal/new_disposal_plan', 'id' => 'new_disposal_plan', 'classes' => '');
        $menu_array['disposal']['child']['view_disposal_plans'] = array('text' => 'All  Disposal Plans ', 'url' => base_url() . 'disposal/view_disposal_plan', 'id' => 'view_disposal_plan', 'classes' => '');

        #$menu_array['disposal']['child']['disposal_notice'] = array('text' => 'Add  Disposal Notice ', 'url' => base_url() . 'disposal/load_disposal_record_form', 'id' => 'disposal_notice', 'classes' => '');

        #$menu_array['disposal']['child']['view_disposal_notices'] = array('text' => 'Manage Disposal Notices ', 'url' => base_url() . 'disposal/view_disposal_records', 'id' => 'view_disposal_notices', 'classes' => '');

        $menu_array['disposal']['child']['disposal_invitation_for_bids'] = array('text' => 'New Bid', 'url' => base_url() . 'disposal/load_bid_invitation_form', 'id' => 'create_invitation_for_bids', 'classes' => '');

        $menu_array['disposal']['child']['view_disposal_bid_invitations'] = array('text' => 'All Bids', 'url' => base_url() . 'disposal/view_bid_invitations', 'id' => 'view_bid_invitations', 'classes' => '');

        $menu_array['disposal']['child']['bid_response'] = array('text' => 'New Letter Of Bid Acceptance', 'url' => base_url() . 'disposal/add_bid_response', 'id' => 'view_bid_invitations', 'classes' => '');
        $menu_array['disposal']['child']['view_bid_responses'] = array('text'=>'All Letters Of Bid Acceptance', 'url'=>base_url().'disposal/manage_bebs', 'id'=>'view_bid_invitations', 'classes'=>'');
        
        
		
        
       /* $menu_array['disposal']['child']['view_bid_responses'] = array('text' => 'Manage Bid Responses ', 'url' => base_url() . 'disposal/view_bid_responses', 'id' => 'view_bid_invitations', 'classes' => '');

        $menu_array['disposal']['child']['bid_activity'] = array('text' => 'Publish Best Evaluated Bidder', 'url' => base_url() . 'disposal/publish_beb', 'id' => 'bid_activity', 'classes' => ''); */


        #Contracts links
        $menu_array['Contracts']['attr'] = array('text' => 'Contracts ', 'url' => 'javascript:void(0);', 'id' => 'menu-pdes', 'classes' => 'fa fa-file');
        $menu_array['Contracts']['child']['award_contract'] = array('text' => 'New Procurement Contract', 'url' => base_url() . 'contracts/contract_award_form', 'id' => 'menu-contract-signing', 'classes' => '');
	$menu_array['Contracts']['child']['view_contracts'] = array('text'=>'All Procurement Contracts', 'url'=>base_url().'contracts/manage_contracts', 'id'=>'menu-published-contract', 'classes'=>'');
	$menu_array['Contracts']['child']['bid_activity'] = array('text'=>'New Disposal Contract', 'url'=>base_url().'disposal/signcontract', 'id'=>'signcontract', 'classes'=>'');
	$menu_array['Contracts']['child']['manage_disposal_contracts'] = array('text'=>'All Disposal Contracts', 'url'=>base_url().'disposal/manage_contracts', 'id'=>'signcontract', 'classes'=>'');



        #Service providers links
        $menu_array['providers']['attr'] = array('text' => 'Service providers', 'url' => 'javascript:void(0);', 'id' => 'menu-users', 'classes' => 'fa fa-briefcase');
		$menu_array['providers']['child']['view_service_providers'] = array('text'=>'View service providers', 'url'=>'javascript:void(0);', 'id'=>'menu-manage-pdes', 'classes'=>'');
		$menu_array['providers']['child']['add_service_providers'] = array('text'=>'Add service provider', 'url'=>'javascript:void(0);', 'id'=>'menu-add-user', 'classes'=>'');


        #Report links
	$menu_array['reports']['attr'] = array('text'=>'Reports', 'url'=>'javascript:void(0);', 'id'=>'menu-view-reports', 'classes'=>'fa fa-files-o');
	$menu_array['reports']['child']['monthly_procurement_reports'] = array('text' => 'Monthly Reports On Procurement', 'url' => base_url() . 'reports/monthly_procurement_reports', 'id' => 'monthly_procurement_reports', 'classes' => '');
        $menu_array['reports']['child']['procurement_plan_reports'] = array('text' => 'Procurement Plan Reports', 'url' => base_url() . 'reports/procurement_plan_reports', 'id' => 'menu-procurement-plan-reports', 'classes' => '');
        $menu_array['reports']['child']['invitation_for_bid_reports'] = array('text' => 'Invitation For Bids Reports', 'url' => base_url() . 'reports/invitation_for_bids_reports', 'id' => 'menu-invitation-for-bid-reports', 'classes' => '');
        $menu_array['reports']['child']['best_evaluated_bidder_reports'] = array('text' => 'Best Evaluated Bidder Reports', 'url' => base_url() . 'reports/best_evaluated_bidder_reports', 'id' => 'menu-best-evaluated-bidder-reports', 'classes' => '');
        $menu_array['reports']['child']['contract_award_reports'] = array('text' => 'Signed Contract Reports', 'url' => base_url() . 'reports/contract_award_reports', 'id' => 'menu-contract-award-reports', 'classes' => '');
        #$menu_array['reports']['child']['completed_contracts_report'] = array('text' => 'Completed Contracts Reports', 'url' => base_url() . 'reports/report_panel', 'id' => 'menu-completed-contracts-reports', 'classes' => '');
        $menu_array['reports']['child']['ppms_reports'] = array('text' => 'Performance Reports', 'url' => base_url() . 'reports/ppms', 'id' => 'menu-ppms-reports', 'classes' => '');
        $menu_array['reports']['child']['disposal_reports'] = array('text' => 'Disposal Reports', 'url' => base_url() . 'reports/report_panel', 'id' => 'menu-completed-contracts-reports', 'classes' => '');
        $menu_array['reports']['child']['disposal_reports'] = array('text' => 'Disposal Reports', 'url' => base_url() . 'reports/disposal', 'id' => 'menu-disposal-reports', 'classes' => '');
        $menu_array['reports']['child']['suspended_provider_reports'] = array('text' => 'Suspended providers Reports', 'url' => base_url() . 'reports/suspended_providers', 'id' => 'menu-suspended_providers-reports', 'classes' => '');


        #User links
        $menu_array['users']['attr'] = array('text' => 'Users', 'url' => 'javascript:void(0);', 'id' => 'menu-users', 'classes' => 'fa fa-user');
        $menu_array['users']['child']['view_user_list'] = array('text' => 'Manage Users', 'url' => base_url() . 'admin/manage_users', 'id' => 'menu-manage-users', 'classes' => '');
        $menu_array['users']['child']['add_users'] = array('text' => 'Add User', 'url' => base_url() . 'user/load_user_form', 'id' => 'menu-add-user', 'classes' => '');
        $menu_array['users']['child']['view_user_groups'] = array('text' => 'User Groups', 'url' => base_url() . 'admin/manage_user_groups', 'id' => 'menu-user-groups', 'classes' => '');
        $menu_array['users']['child']['add_user_group'] = array('text' => 'Add User Group', 'url' => base_url() . 'admin/user_group_form', 'id' => 'menu-add-user-group', 'classes' => '');

        #Forms links
        $menu_array['forms']['attr'] = array('text' => 'Forms', 'url' => 'javascript:void(0);', 'id' => 'ppda-forms', 'classes' => 'fa fa-file-text');
        $menu_array['forms']['child']['download-forms'] = array('text' => 'Download Forms', 'url' => 'http://ppda.go.ug/index.php/ppda-forms.html', 'id' => 'menu-manage-users', 'classes' => '','target'=>'_blank');
       # $menu_array['forms']['child']['add_users'] = array('text' => 'Form 48', 'url' => '#', 'id' => 'menu-add-user', 'classes' => '');


        #PDE links
        $menu_array['pdes']['attr'] = array('text' => 'PDEs', 'url' => 'javascript:void(0);', 'id' => 'menu-pdes', 'classes' => ' fa fa-university');
        $menu_array['pdes']['child']['view_pdes'] = array('text' => 'Manage PDEs', 'url' => base_url() . 'admin/manage_pdes', 'id' => 'menu-manage-pdes', 'classes' => '');
        $menu_array['pdes']['child']['create_pde'] = array('text' => 'Add PDE', 'url' => base_url() . 'admin/load_pde_form', 'id' => 'menu-add-pde', 'classes' => '');

        #PDE TYPES
        $menu_array['pdes']['child']['manage_pdetypes'] = array('text' => 'Manage PDE Types', 'url' => base_url() . 'admin/manage_pdetypes', 'id' => 'menu-manage-types', 'classes' => '');
        $menu_array['pdes']['child']['add_pdetype'] = array('text' => 'Add PDE Type', 'url' => base_url() . 'admin/load_pdetype_form', 'id' => 'menu-add-pdetype', 'classes' => '');

        #Providers Links
        $menu_array['providers']['attr'] = array('text' => 'Providers ', 'url' => 'javascript:void(0);', 'id' => 'menu-providers', 'classes' => ' fa fa-briefcase');
        $menu_array['providers']['child']['suspend_provider'] = array('text' => 'Suspend Provider', 'url' => base_url() . 'providers/suspend_provider', 'id' => 'menu-unconfirmed-providers', 'classes' => '');
        $menu_array['providers']['child']['manage_suspended_providers'] = array('text' => ' Suspended Providers', 'url' => base_url() . 'providers/manage_suspended_providers', 'id' => 'menu-unconfirmed-providers', 'classes' => '');
        
         $menu_array['providers']['child']['view_bids_received'] = array('text' => 'Internationally Suspended Providers', 'url' =>  'http://web.worldbank.org/external/default/main?theSitePK=84266&contentMDK=64069844&menuPK=116730&pagePK=64148989&piPK=64148984', 'id' => 'menu-unconfirmed-providers', 'classes' => '','target'=>'_blank');
        /*
           $menu_array['providers']['child']['view_bids_received'] = array('text'=>'Un Confirmed Providers', 'url'=>base_url() . 'providers/unconfirmed', 'id'=>'menu-unconfirmed-providers', 'classes'=>'');
        */

        #Help links
        $menu_array['help']['attr'] = array('text' => 'Help ', 'url' => 'javascript:void(0);', 'id' => 'menu-help', 'classes' => 'fa fa-question-circle');
        $menu_array['help']['child']['help-link'] = array('text' => 'Help Information', 'url' => '#', 'id' => 'help-link', 'classes' => '');


		return $menu_array;
	}

    function find_my_parent($menu_item = '')
	{
        $parent_index = '';
        $menu_items = $this->menu_bucket();

        foreach ($menu_items as $item_key => $item)
		{
            if ($item_key == $menu_item)
			{
                return '';
            } else
			{
                if (is_array($item) && !empty($item['child'])) {
                    foreach ($item['child'] as $child_key => $child) {
                        if ($child_key == $menu_item) {
                            return $item_key;
                        }
                    }
                }
			}
		}

        return $parent_index;

	}


    #Find menu parent

	function display_menu($current_menu = '')
	{
		$nav_menu_str = '';

		$menu_array = $this->menu_bucket();

		if(check_user_access($this, 'manage_reports'));

		if(!empty($menu_array))
		{
			echo '<ul class="sidebar-menu">';

            foreach ($menu_array AS $text => $link) {
                $parent_links_html = '<li class="' . (!empty($link['child']) ? ' has-sub' : '') .
									(($text == $current_menu || $text == $this->find_my_parent($current_menu))? ' active open' : '') .'">'.
					 				'<a href="'. $link['attr']['url'] . '"';
                                    
                                    $parent_links_html .= $link['attr']['id'] . '" class="">'.
					 				'<span class="icon-box"><i class="' . $link['attr']['classes'] . '"></i></span>'.
					 				$link['attr']['text'].
					 				(!empty($link['child'])? '<span class="arrow"></span>' : '').
					 				'</a>';

				$child_links_html = '';

                if (!empty($link['child'])) {
					foreach($link['child'] as $child_text=>$child_link)
					{
                        if (check_user_access($this, $child_text) || in_array($child_text, array('my_profile', 'log_out', 'home')))
						{
							$child_links_html .= '<li class="'. (($child_text == $current_menu)? 'active' : '') .'">'.
												 '<a href="'.  $child_link['url'] . '" class="">'.
												 $child_link['text'];

                            if(!empty($child_link['attr']['target']))
                            $child_links_html .='target="'.$child_link['attr']['target'].'"' ;
											$child_links_html	.= '</a>'.
                                '</li>';
						}
					}
				}

                if (!empty($child_links_html))
				{
					print $parent_links_html.
                        '<ul id="' . $link['attr']['id'] . '-child" class="sub">' .
						  $child_links_html .
						  '</ul></li>';
				}
            }

			echo "</ul>";
		}
	}
	
}

?>