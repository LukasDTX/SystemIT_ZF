<?php

namespace Telefon\Controller;

use Telefon\Model\Telefon;
use Telefon\Form\TelefonForm;
use Telefon\Form\TelefonFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class TelefonController extends AbstractActionController {

    protected $telefonTable;
    protected $dzialTable;
    protected $uzytkownikTable;

    public function getTelefonTable() {
        if (!$this->telefonTable) {
            $sm = $this->getServiceLocator();
            $this->telefonTable = $sm->get('Telefon\Model\TelefonTable');
        }
        return $this->telefonTable;
    }

    //dzial
    public function getDzialTable() {
        if (!$this->dzialTable) {
            $sm = $this->getServiceLocator();
            $this->dzialTable = $sm->get('Telefon\Model\DzialTable');
        }
        return $this->dzialTable;
    }

    //uzytkownik
    public function getUzytkownikTable() {
        if (!$this->uzytkownikTable) {
            $sm = $this->getServiceLocator();
            $this->uzytkownikTable = $sm->get('Telefon\Model\UzytkownikTable');
        }
        return $this->uzytkownikTable;
    }

    public function detailAction() {
        $id = (int) $this->params()->fromRoute('id');
        $telefon = $this->getTelefonTable()->getTelefon($id);
//        
//        $dzialy = $this->getDzialTable()->fetchAll();
//        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();
//        $form = new TelefonForm($dzialy, $uzytkownicy);
        $telefony = $this->getTelefonTable()
                ->fetchAll($select, $markaFiltr, $modelFiltr, $dzialFiltr);
        foreach ($telefony as $tele) : {
                if ($tele->id == $id)
                    $telefon = $tele;
            }
        endforeach;
        return new ViewModel(array(
            'telefon' => $telefon,
            'form' => $form
        ));
    }
        public function indexAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $markaFiltr = $request->getPost('marka');
            $modelFiltr = $request->getPost('model');
            $dzialFiltr = $request->getPost('dzial_id');
        }
        $dzialy = $this->getDzialTable()->fetchAll();
  //      \Zend\Debug\Debug::dump($dzialy);die();
        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();

        $form = new TelefonForm($dzialy, $uzytkownicy);
        $select = new Select();
//\Zend\Debug\Debug::dump($form);die();
        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $telefony = $this->getTelefonTable()
                ->fetchAll($select->order($order_by . ' ' . $order), $markaFiltr, $modelFiltr, $dzialFiltr);

        $itemsPerPage = 5;
        $telefony->current();
        $paginator = new Paginator(new paginatorIterator($telefony));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(7);

        return new ViewModel(array(
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'paginator' => $paginator,
            'form' => $form
        ));
    }

    
    
    

    public function indexxAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $markaFiltr = $request->getPost('marka');
            $modelFiltr = $request->getPost('model');
            $dzialFiltr = $request->getPost('dzial_id');
        }
        $dzialy = $this->getDzialTable()->fetchAll();
        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();

        $form = new TelefonForm($dzialy, $uzytkownicy);
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $telefony = $this->getTelefonTable()
                ->fetchAll($select->order($order_by . ' ' . $order), $markaFiltr, $modelFiltr, $dzialFiltr);

        $itemsPerPage = 5;
        $telefony->current();
        $paginator = new Paginator(new paginatorIterator($telefony));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(7);
        
        $this->layout('layout/x');
        
        return new ViewModel(array(
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'paginator' => $paginator,
            'form' => $form
        ));
    }

    public function addAction() {
        $dzialy = $this->getDzialTable()->fetchAll();
        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();

        $form = new TelefonForm($dzialy, $uzytkownicy); //$selectData);
        $form->get('submit')->setAttribute('value', 'Dodaj');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $telefon = new Telefon();
            ////filter
            $inputFilter = new TelefonFilter();
            $form->setInputFilter($inputFilter);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $telefon->exchangeArray($form->getData());
                $this->getTelefonTable()->saveTelefon($telefon);
                return $this->redirect()->toRoute('telefon');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $dzialy = $this->getDzialTable()->fetchAll();
        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('telefon', array('action' => 'add'));
        }
        $telefon = $this->getTelefonTable()->getTelefon($id);
        // var_dump($uzytkownik->stanowisko_id);
        // return 0;
        $form = new TelefonForm($dzialy, $uzytkownicy);
        $form->bind($telefon);

        $form->get('submit')->setAttribute('value', 'Zapisz');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getTelefonTable()->saveTelefon($telefon);
                //\Zend\Debug\Debug::dump($uzytkownik->nazwisko);
                //echo $uzytkownik->stanowisko_id;
                // die();
                ////Redirect to list of telefons
                return $this->redirect()->toRoute('telefon');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params('id');

        if (!$id) {
            return $this->redirect()->toRoute('telefon');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'Nie');
            if ($del == 'Tak') {
                $id = (int) $request->getPost()->get('id');
                $this->getTelefonTable()->deleteTelefon($id);
            }

            ////Redirect to list of telefons
            return $this->redirect()->toRoute('telefon');
        }

        return array(
            'id' => $id,
            'telefon' => $this->getTelefonTable()->getTelefon($id)
        );
    }

}
