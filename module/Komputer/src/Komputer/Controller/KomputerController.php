<?php

namespace Komputer\Controller;

use Komputer\Form\SzukajForm;
use Komputer\Model\Komputer;
use Komputer\Form\KomputerForm;
use Komputer\Form\KomputerFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

//use ZendPdf\PdfDocument as pdfdoc;

class KomputerController extends AbstractActionController {

    protected $komputerTable;
    protected $dzialTable;
    protected $uzytkownikTable;

    public function getKomputerTable() {
        if (!$this->komputerTable) {
            $sm = $this->getServiceLocator();
            $this->komputerTable = $sm->get('Komputer\Model\KomputerTable');
        }
        return $this->komputerTable;
    }

    //dzial
    public function getDzialTable() {
        if (!$this->dzialTable) {
            $sm = $this->getServiceLocator();
            $this->dzialTable = $sm->get('Komputer\Model\DzialTable');
        }
        return $this->dzialTable;
    }

    //uzytkownik
    public function getUzytkownikTable() {
        if (!$this->uzytkownikTable) {
            $sm = $this->getServiceLocator();
            $this->uzytkownikTable = $sm->get('Komputer\Model\UzytkownikTable');
        }
        return $this->uzytkownikTable;
    }

    public function detailAction() {
        $id = (int) $this->params()->fromRoute('id');
        $komputer = $this->getKomputerTable()->getKomputer($id);
//        
//        $dzialy = $this->getDzialTable()->fetchAll();
//        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();
//        $form = new KomputerForm($dzialy, $uzytkownicy);
        $komputery = $this->getKomputerTable()
                ->fetchAll($select, $markaFiltr, $modelFiltr, $dzialFiltr, $uzytkownikFiltr, $ewidFiltr, $inwentFiltr);
        foreach ($komputery as $komp) : {
                if ($komp->id == $id)
                    $komputer = $komp;
            }
        endforeach;
        //\Zend\Debug\Debug::dump($komputer);die();
        return new ViewModel(array(
            'komputer' => $komputer,
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
            $ewidFiltr = $request->getPost('nr_ewid');
            $inwentFiltr = $request->getPost('nr_inwent');
        }
        $dzialy = $this->getDzialTable()->fetchAll();
        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();
        $szukaj = new SzukajForm($dzialy, $uzytkownicy);
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'marka';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $komputery = $this->getKomputerTable()
                ->fetchAll($select->order($order_by . ' ' . $order), $markaFiltr, $modelFiltr, $dzialFiltr, $uzytkownikFiltr, $ewidFiltr, $inwentFiltr);
        $itemsPerPage = 5;

        $komputery->current();
        $paginator = new Paginator(new paginatorIterator($komputery));
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
//$pdf = new pdfdoc();
//$pdf1 = new pdfdoc();
//$pdf1->save("hclintel.pdf");
        $request = $this->getRequest();
        if ($request->isPost()) {
            $markaFiltr = $request->getPost('marka');
            $modelFiltr = $request->getPost('model');
            $dzialFiltr = $request->getPost('dzial_name');
            $uzytkownikFiltr = $request->getPost('uzytkownik_name');
            $ewidFiltr = $request->getPost('nr_ewid');
            $inwentFiltr = $request->getPost('nr_inwent');
        }
        $dzialy = $this->getDzialTable()->fetchAll();
        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();
        $szukaj = new SzukajForm($dzialy, $uzytkownicy);
        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'marka';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $komputery = $this->getKomputerTable()
                ->fetchAll($select->order($order_by . ' ' . $order), $markaFiltr, $modelFiltr, $dzialFiltr, $uzytkownikFiltr, $ewidFiltr, $inwentFiltr);
        $itemsPerPage = 5;

        $komputery->current();
        $paginator = new Paginator(new paginatorIterator($komputery));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(7);
//******************PDF*******************************
        $pdf = new \ZendPdf\PdfDocument();
        $font = \ZendPdf\Font::fontWithName(\ZendPdf\Font::FONT_COURIER);
        $pdf->pages[] = $pdf->newPage(\ZendPdf\Page::SIZE_A4)
//        ->setFillColor(new \ZendPdf\Color\Rgb(150,150,100))
                ->setFont($font, 20)
                ->setFillColor(new \ZendPdf\Color\Cmyk(1, 0, 0, 0))
                ->drawRectangle(200, 20, 600, 350)
                ->drawText('Helvetica 36 text string', 60, 500);

//        ->setFont(\ZendPdf\Font::FONT_COURIER, 36)
//        \ZendPdf\
        $pdf->save("hclintel.pdf");
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
        $form = new KomputerForm($uzytkownicy);
        $form->get('submit')->setAttribute('value', 'Dodaj');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = array_merge_recursive(
                    $request->getPost()->toArray(), $request->getFiles()->toArray()
            );
            $komputer = new Komputer();
            ////****filter
            $inputFilter = new KomputerFilter();
            $form->setInputFilter($inputFilter);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $tmp = $request->getFiles()->toArray();
                $dest = $_SERVER["DOCUMENT_ROOT"] . "/Zend/dane/" . str_replace("/", "", $post["nr_inwent"]);
                if (!is_dir($dest)) {
                    mkdir($dest, 0777);
                    mkdir($dest . "/gw", 0777);
                    mkdir($dest . "/fv", 0777);
                }
                move_uploaded_file($tmp["gw"]["tmp_name"], $dest . "/gw/" . $tmp["gw"]["name"]);
                move_uploaded_file($tmp["fv"]["tmp_name"], $dest . "/fv/" . $tmp["fv"]["name"]);
                $komputer->exchangeArray($post);
                $this->getKomputerTable()->saveKomputer($komputer);
                return $this->redirect()->toRoute('komputer');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $uzytkownicy = $this->getUzytkownikTable()->fetchAll();
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()
                    ->toRoute('komputer', array('action' => 'add'));
        }
        $komputer = $this->getKomputerTable()->getKomputer($id);
        $form = new KomputerForm($uzytkownicy);
        $form->bind($komputer);
        $form->get('submit')->setAttribute('value', 'Zapisz');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getKomputerTable()->saveKomputer($komputer);
                return $this->redirect()->toRoute('komputer');
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
            return $this->redirect()->toRoute('komputer');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('delete', 'Nie');
            if ($del == 'Tak') {
                $id = (int) $request->getPost()->get('id');
                $this->getKomputerTable()->deleteKomputer($id);
            }
            return $this->redirect()->toRoute('komputer');
        }
        return array(
            'id' => $id,
            'komputer' => $this->getKomputerTable()->getKomputer($id)
        );
    }

}
