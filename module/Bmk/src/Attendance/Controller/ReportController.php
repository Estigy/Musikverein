<?php

namespace Attendance\Controller;

use \DateTime;

use Application\Controller\BaseController;

use Attendance\Entity\Entry;
use Attendance\Entity\Event;
use Attendance\Entity\Sheet;
use Attendance\Form\EventForm;
use Attendance\Form\SheetForm;

use Zend\View\Model\ViewModel;

class ReportController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $entities = $em->getRepository('\Attendance\Entity\Sheet')->getPaginator();

        return new ViewModel(array(
            'sheets' => $entities
        ));
    }

    public function resultAction()
    {
        $sheetIds = $this->params()->fromQuery('sheetIds', array());

        if (empty($sheetIds)) {
            return $this->redirect()->toRoute('attendanceReport');
        }

        $rankingData = $this->getRankingData($sheetIds);

        return array(
            'sheetIds' => $sheetIds,
            'sheets'  => $rankingData['sheets'],
            'ranking' => $rankingData['ranking'],
            'totalEvents' => $rankingData['eventCount'],
        );
    }

    public function exportAction()
    {
        $sheetIds = $this->params()->fromQuery('sheetIds', array());

        if (empty($sheetIds)) {
            return $this->redirect()->toRoute('attendanceReport');
        }

        $rankingData = $this->getRankingData($sheetIds);

        $s = '';
        $s .= $this->echoCsvData(array('Listen'));
        foreach ($rankingData['sheets'] as $sheet) {
            $s .= $this->echoCsvData(array($sheet->band . ' ' . $sheet->year . ',  ' . $sheet->name));
        }
        $s .= $this->echoCsvData(array(''));

        $s .= $this->echoCsvData(array('Anzahl Termine:', $rankingData['eventCount'], 'Anzahl Personen:', count($rankingData['ranking'])));
        $s .= $this->echoCsvData(array(''));

        $s .= $this->echoCsvData(array('Rang', 'Nachname', 'Vorname', 'Anzahl'));

        $i = 0;
        $oldI = 0;
        $oldCount = 0;
        foreach ($rankingData['ranking'] as $rank) {
            $i++;
            if ($oldCount != $rank['anzahl']) {
                $oldCount = $rank['anzahl'];
                $oldI = $i;
            }
            $s .= $this->echoCsvData(array($oldI, $rank[0]->lastname, $rank[0]->firstname, $rank['anzahl']));
        }

        $r = $this->getResponse();

        $r->setContent($s);

        $r->getHeaders()->addHeaders(array(
            'Content-Encoding' => 'UTF-8',
            'Content-Type' => 'application/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename=anwesenheit.xls',
            'Pragma' => 'no-cache',
        ));

        return $r;
    }

    protected function getRankingData($sheetIds)
    {
        $sheets      = array();
        $totalEvents = 0;

        foreach ($sheetIds as $sheetId) {
            $sheet = $this->getEntityManager()->find('\Attendance\Entity\Sheet', $sheetId);
            if ($sheet == null) {
                return $this->redirect()->toRoute('attendanceReport');
            }
            $totalEvents += count($sheet->events);
            $sheets[] = $sheet;
        }

        $ranking = $this->getEntityManager()->getRepository('\Attendance\Entity\Sheet')->getRankingResult($sheetIds);

        return array(
            'sheets'     => $sheets,
            'eventCount' => $totalEvents,
            'ranking'    => $ranking
        );
    }

    protected function echoCsvData($array)
    {
        $array = array_map('utf8_decode', $array);
        foreach ($array as $key => $data) {
            $array[$key] = '"' . $data . '"';
        }
        return implode("\t", $array) . "\r\n";
    }

}
