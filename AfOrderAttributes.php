<?php

namespace AfOrderAttributes;

use Shopware\Components\Plugin;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Shopware-Plugin AfOrderAttributes.
 */
class AfOrderAttributes extends Plugin
{

    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('af_order_attributes.plugin_dir', $this->getPath());
        parent::build($container);
    }

    public static function getSubscribedEvents(){
      return [
        'Enlight_Controller_Action_PostDispatch_Frontend_Account' => 'onAccount', 
      ];
    }

    public function onAccount(\Enlight_Event_EventArgs $args){
      $controller = $args->getSubject();
      $view = $controller->View();
      
      $user = $view->getAssign('sUserData');
      if(!$user){
        return;
      }else{
        $userID = $user['additional']['user']['userID'];
        $orders = $this->getOrders($userID);

        if($orders){
          foreach($orders as $order){
            $orderAttributes = $this->getOrderAttributes($order['id']);
            $attributes[] = $orderAttributes['0'];
          }

          //dump($attributes);
          $view->assign('AfOrderAttributes', $attributes);
        }else{
          return;
        }
      }
    }

    public function getOrderAttributes($orderId){
      $db = Shopware()->Db();
      $query = "SELECT * FROM s_order_attributes WHERE orderID = '".$orderId."'";
      $orderAttributes = $db->fetchAll($query);
      return $orderAttributes;
    }

    public function getOrders($userId){
      $db = Shopware()->Db();
      $query = "SELECT * FROM s_order WHERE userID = '".$userId."'";
      $orders = $db->fetchAll($query);
      return $orders;
    }

}
