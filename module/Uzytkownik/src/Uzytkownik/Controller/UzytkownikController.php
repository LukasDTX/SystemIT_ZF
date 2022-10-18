<?php

namespace Uzytkownik\Controller;

use Uzytkownik\Model\Uzytkownik;
use Uzytkownik\Form\UzytkownikForm;
use Uzytkownik\Form\SzukajForm;
use Uzytkownik\Form\SzukajOsobaForm;
use Uzytkownik\Form\UzytkownikFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

//use Komputer\Controller\Komputer as Komputer;

class UzytkownikController extends AbstractActionController {

    protected $uzytkownikTable;
    protected $dzialTable;
    protected $komputerTable;

    public function getUzytkownikTable() {
        if (!$this->uzytkownikTable) {
            $sm = $this->getServiceLocator();
            $this->uzytkownikTable = $sm->get('Uzytkownik\Model\UzytkownikTable');
        }
        return $this->uzytkownikTable;
    }

    //komputer
    public function getKomputerTable() {
        if (!$this->komputerTable) {
            $sm = $this->getServiceLocator();
            $this->komputerTable = $sm->get('Uzytkownik\Model\KomputerTable');
        }
        return $this->komputerTable;
    }

    public function getTelefonTable() {
        if (!$this->telefonTable) {
            $sm = $this->getServiceLocator();
            $this->telefonTable = $sm->get('Uzytkownik\Model\TelefonTable');
        }
        return $this->telefonTable;
    }

    //dzial
    public function getDzialTable() {
        if (!$this->dzialTable) {
            $sm = $this->getServiceLocator();
            $this->dzialTable = $sm->get('Uzytkownik\Model\DzialTable');
        }
        return $this->dzialTable;
    }
    public function osobapdfAction() {
        $request = $this->getRequest();
        //$dz = 0;
        if ($request->isPost()) {
            $uzytkownikFiltr = $request->getPost('uzytkownik_id');
            $uzytko = $this->getUzytkownikTable()->downAll();
            foreach ($uzytko as $res) {
                //$selectData[$res['id']] = $res['dzial'];
                if ($res['id'] == $uzytkownikFiltr) {
                    $dz = $res['nazwisko']." ".$res['imie'];
                }
            }
        }
        //\Zend\Debug\Debug::dump($dz);die();
        $uzytko = $this->getUzytkownikTable()->downAll();
        //$dzialy = $this->getDzialTable()->fetchAll();
        $szukaj = new SzukajOsobaForm($uzytko);
        $komputery = $this->getKomputerTable()->downAll($uzytkownikFiltr);
        $telefony = $this->getTelefonTable()->downAll($uzytkownikFiltr);
        $select = new Select();
        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'nazwisko';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
        $uzytkownicy = $this->getUzytkownikTable()
                ->fetchAll($select->order($order_by . ' ' . $order), $imieFiltr, $dz, $dzialFiltr, $mailFiltr, $komFiltr);
        foreach ($uzytkownicy as $pc) :{
            echo $pc->nazwisko;
            
        }
    endforeach;
    foreach ($uzytkownicy as $pc) :{
            echo $pc->nazwisko;
            echo "<br />";
            
        }
    endforeach;
    die();
        //\Zend\Debug\Debug::dump($uzytkownicy);die();
        
        $pdf = new \ZendPdf\PdfDocument();
        $font = \ZendPdf\Font::fontWithPath('arial.ttf');
        $pdf->pages[] = $pdf->newPage(\ZendPdf\Page::SIZE_A4)
//        ->setFillColor(new \ZendPdf\Color\Rgb(150,150,100))
                ->setFont($font, 20)
                ->setFillColor(new \ZendPdf\Color\Cmyk(1, 1, 1, 1))
                //->drawRectangle(200, 20, 600, 350)
//                ->drawText($uzytkown, 20, 800, "UTF-8")
                ->drawText("test", 20, 820, "UTF-8");
//        $x = 0;
//                foreach ($komputery as $pc) :{
//                    $text = " kupa";
//                    $x= $x +50;
//                $pdf->pages[] = $page->drawText("jhdbsvjhb", 20, 820, "UTF-8");
//                }
//        endforeach;
        $pdf->save("1.pdf");
        $uzytkownicy->current();
        //$this->layout('layout/x');
        return new ViewModel(array(
//            'order_by' => $order_by,
//            'order' => $order,
//            'page' => $page,
//            'uzytkownik' => $uzytkownicy,
//            'komputer' => $komputery,
//            'telefon' => $telefony,
//            'form' => $szukaj,
//            'dzial' => $dz
        ));
    }
    
    //********************
    public function dzialAction() {
        $request = $this->getRequest();
        //$dz = 0;
        if ($request->isPost()) {
            $dzialFiltr = $request->getPost('dzial_id');
            //$selectData = array(); //'id' => '0');
            $dzialy = $this->getDzialTable()->fetchAll();
            foreach ($dzialy as $res) {
                //$selectData[$res['id']] = $res['dzial'];
                if ($res['id'] == $dzialFiltr) {
                    $dz = $res['dzial'];
                }
            }
        }
        $dzialy = $this->getDzialTable()->fetchAll();
        $szukaj = new SzukajForm($dzialy);
        $komputery = $this->getKomputerTable()->fetchAll($dzialFiltr);
        $telefony = $this->getTelefonTable()->fetchAll($dzialFiltr);

        $select = new Select();
        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'nazwisko';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $uzytkownicy = $this->getUzytkownikTable()
                ->fetchAll($select->order($order_by . ' ' . $order), $imieFiltr, $nazwiskoFiltr, $dzialFiltr, $mailFiltr, $komFiltr);
        $uzytkownicy->current();
        //$this->layout('layout/x');
        return new ViewModel(array(
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'uzytkownik' => $uzytkownicy,
            'komputer' => $komputery,
            'telefon' => $telefony,
            'form' => $szukaj,
            'dzial' => $dz
        ));
    }

    public function indexAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $imieFiltr = $request->getPost('imie');
            $nazwiskoFiltr = $request->getPost('nazwisko');
            $dzialFiltr = $request->getPost('dzial_id');
            $mailFiltr = $request->getPost('mail');
            $komFiltr = $request->getPost('kom');
        }
        $dzialy = $this->getDzialTable()->fetchAll();
        $szukaj = new SzukajForm($dzialy);
        $komputery = $this->getKomputerTable()->fetchAll($dzialFiltr);
        $telefony = $this->getTelefonTable()->fetchAll($dzialFiltr);

        $select = new Select();
        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'nazwisko';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $uzytkownicy = $this->getUzytkownikTable()
                ->fetchAll($select->order($order_by . ' ' . $order), $imieFiltr, $nazwiskoFiltr, $dzialFiltr, $mailFiltr, $komFiltr);
        $itemsPerPage = 5;
        $uzytkownicy->current();
        $paginator = new Paginator(new paginatorIterator($uzytkownicy));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(7);
        //$this->layout('layout/x');
        return new ViewModel(array(
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'paginator' => $paginator,
            'komputer' => $komputery,
            'telefon' => $telefony,
            'form' => $szukaj
        ));
    }

    public function indexxAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $imieFiltr = $request->getPost('imie');
            $nazwiskoFiltr = $request->getPost('nazwisko');
            $dzialFiltr = $request->getPost('dzial_id');
            $mailFiltr = $request->getPost('mail');
            $komFiltr = $request->getPost('kom');
        }
        $dzialy = $this->getDzialTable()->fetchAll();
        $szukaj = new SzukajForm($dzialy);
        $komputery = $this->getKomputerTable()->fetchAll($dzialFiltr);
        $telefony = $this->getTelefonTable()->fetchAll($dzialFiltr);
        $select = new Select();
        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'nazwisko';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $uzytkownicy = $this->getUzytkownikTable()
                ->fetchAll($select->order($order_by . ' ' . $order), $imieFiltr, $nazwiskoFiltr, $dzialFiltr, $mailFiltr, $komFiltr);
        $itemsPerPage = 5;
        $uzytkownicy->current();
        $paginator = new Paginator(new paginatorIterator($uzytkownicy));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(7);
        $this->layout('layout/x');
        return new ViewModel(array(
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'paginator' => $paginator,
            'komputer' => $komputery,
            'telefon' => $telefony,
            'form' => $szukaj
        ));
    }

    public function addAction() {
        $dzialy = $this->getDzialTable()->fetchAll();
        $form = new UzytkownikForm($dzialy);
        $form->get('submit')->setAttribute('value', 'Dodaj');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $uzytkownik = new Uzytkownik();
            ////filter
            $inputFilter = new UzytkownikFilter();
            $form->setInputFilter($inputFilter);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $uzytkownik->exchangeArray($form->getData());
                $this->getUzytkownikTable()->saveUzytkownik($uzytkownik);
                //// Redirect to list of telefons
                return $this->redirect()->toRoute('uzytkownik');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $dzialy = $this->getDzialTable()->fetchAll();
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('uzytkownik', array('action' => 'add'));
        }
        $uzytkownik = $this->getUzytkownikTable()->getUzytkownik($id);

        $form = new UzytkownikForm($dzialy);
        $form->bind($uzytkownik);
        $form->get('submit')->setAttribute('value', 'Zapisz');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getUzytkownikTable()->saveUzytkownik($uzytkownik);
                return $this->redirect()->toRoute('uzytkownik');
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
            return $this->redirect()->toRoute('uzytkownik');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'Nie');
            if ($del == 'Tak') {
                $id = (int) $request->getPost()->get('id');
                $this->getUzytkownikTable()->deleteUzytkownik($id);
            }
            return $this->redirect()->toRoute('uzytkownik');
        }
        return array(
            'id' => $id,
            'uzytkownik' => $this->getUzytkownikTable()->getUzytkownik($id)
        );
    }

    public function osobaAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $uzytkownikFiltr = $request->getPost('uzytkownik_id');
            $uzytko = $this->getUzytkownikTable()->downAll();
            foreach ($uzytko as $res) {
                if ($res['id'] == $uzytkownikFiltr) {
                    $dz = $res['nazwisko']." ".$res['imie'];
                }
            }
        }
        $uzytko = $this->getUzytkownikTable()->downAll();
        $szukaj = new SzukajOsobaForm($uzytko);
        $komputery = $this->getKomputerTable()->downAll($uzytkownikFiltr);
        $telefony = $this->getTelefonTable()->downAll($uzytkownikFiltr);
        
        
        $select = new Select();
        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'nazwisko';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
        $uzytkownicy = $this->getUzytkownikTable()
                ->fetchAll($select->order($order_by . ' ' . $order), $imieFiltr, $dz, $dzialFiltr, $mailFiltr, $komFiltr);


        $uzytkownicy->current();
        //$this->layout('layout/x');
        return new ViewModel(array(
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'uzytkownik' => $uzytkownicy,
            'komputer' => $komputery,
            'telefon' => $telefony,
            'form' => $szukaj,
            'dzial' => $dz
        ));
    }

}
