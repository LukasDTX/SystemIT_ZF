<?php

namespace Telefon\Controller;

use Telefon\Form\SzukajForm;
use Telefon\Model\Telefon;
use Telefon\Form\TelefonForm;
use Telefon\Form\TelefonFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

//use ZendPdf\PdfDocument as pdfdoc;

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

    public function getDzialTable() {
        if (!$this->dzialTable) {
            $sm = $this->getServiceLocator();
            $this->dzialTable = $sm->get('Telefon\Model\DzialTable');
        }
        return $this->dzialTable;
    }

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
        $telefony = $this->getTelefonTable()
                ->fetchAll($select, $markaFiltr, $modelFiltr, $dzialFiltr,
                        $uzytkownikFiltr, $ewidFiltr, $inwentFiltr);
        foreach ($telefony as $komp) : {
                if ($komp->id == $id)
                    $telefon = $komp;
            }
        endforeach;
        return new ViewModel(array(
            'telefon' => $telefon,
            'form' => $form
        ));
    }

    public function indexxAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $markaFiltr = $request->getPost('marka');
            $modelFiltr = $request->getPost('model');
            $dzialFiltr = $request->getPost('dzial_name');
            $uzytkownikFiltr = $request->getPost('uzytkownik_name');
            $imeiFiltr = $request->getPost('imei');
            $inwentFiltr = $request->getPost('nr_inwent');
        }
        $dzialy = $this->getDzialTable()->fetchAll();
        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();
        $szukaj = new SzukajForm($dzialy, $uzytkownicy);
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'marka';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $telefony = $this->getTelefonTable()
                ->fetchAll($select->order($order_by . ' ' . $order), $markaFiltr, $modelFiltr, $dzialFiltr, $uzytkownikFiltr, $imeiFiltr, $inwentFiltr);
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
            'form' => $szukaj
        ));
    }

    public function indexAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $markaFiltr = $request->getPost('marka');
            $modelFiltr = $request->getPost('model');
            $dzialFiltr = $request->getPost('dzial_name');
            $uzytkownikFiltr = $request->getPost('uzytkownik_name');
            $imeiFiltr = $request->getPost('imei');
            $inwentFiltr = $request->getPost('nr_inwent');
        }
        $dzialy = $this->getDzialTable()->fetchAll();
        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();
        $szukaj = new SzukajForm($dzialy, $uzytkownicy);
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'marka';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $telefony = $this->getTelefonTable()
                ->fetchAll($select->order($order_by . ' ' . $order), $markaFiltr, $modelFiltr, $dzialFiltr, $uzytkownikFiltr,$inwentFiltr, $imeiFiltr);
        $itemsPerPage = 5;
        //\Zend\Debug\Debug::dump($dzialy[4]['dzial']);die();
        $telefony->current();
        $paginator = new Paginator(new paginatorIterator($telefony));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(7);

        return new ViewModel(array(
            //'pdf1' => $pdf1,
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'paginator' => $paginator,
            'form' => $szukaj
        ));
    }

    public function addAction() {
        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();
        $form = new TelefonForm($uzytkownicy);
        $form->get('submit')->setAttribute('value', 'Dodaj');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = array_merge_recursive(
                    $request->getPost()->toArray(), $request->getFiles()->toArray()
            );
            $telefon = new Telefon();
            ////****filter
            $inputFilter = new TelefonFilter();
            $form->setInputFilter($inputFilter);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $tmp = $request->getFiles()->toArray();
                $dest = $_SERVER["DOCUMENT_ROOT"] . "/Zend/dane/" . 
                        str_replace("/", "", $post["imei"]);
                if (!is_dir($dest)) {
                    mkdir($dest, 0777);
                    mkdir($dest . "/gw", 0777);
                    mkdir($dest . "/fv", 0777);
                }
                move_uploaded_file($tmp["gw"]["tmp_name"], $dest . 
                        "/gw/" . $tmp["gw"]["name"]);
                move_uploaded_file($tmp["fv"]["tmp_name"], $dest . 
                        "/fv/" . $tmp["fv"]["name"]);
                $telefon->exchangeArray($post);
                $this->getTelefonTable()->saveTelefon($telefon);
                return $this->redirect()->toRoute('telefon');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('telefon', array('action' => 'add'));
        }
        $telefon = $this->getTelefonTable()->getTelefon($id);
        $form = new TelefonForm($uzytkownicy);
        $form->bind($telefon);
        $form->get('submit')->setAttribute('value', 'Zapisz');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getTelefonTable()->saveTelefon($telefon);
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
            $del = $request->getPost()->get('delete', 'Nie');
            if ($del == 'Tak') {
                $id = (int) $request->getPost()->get('id');
                $this->getTelefonTable()->deleteTelefon($id);
            }
            return $this->redirect()->toRoute('telefon');
        }
        return array(
            'id' => $id,
            'telefon' => $this->getTelefonTable()->getTelefon($id)
        );
    }

}
