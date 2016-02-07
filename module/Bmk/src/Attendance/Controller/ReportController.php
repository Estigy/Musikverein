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

    protected function resultAction()
    {
        $sheetIds = $this->params()->fromQuery('sheetIds', array());

        if (empty($sheetIds)) {
            return $this->redirect()->toRoute('attendanceReport');
        }

        $sheets = array();
        $totalEvents = 0;

        foreach ($sheetIds as $sheetId) {
            $sheet = $this->getEntityManager()->find('\Attendance\Entity\Sheet', $sheetId);
            if ($sheet == null) {
                echo $sheetId . ' not found';
                //die();
                //return $this->redirect()->toRoute('attendanceReport');
            }
            $totalEvents += count($sheet->events);
            $sheets[] = $sheet;
        }

        $ranking = $this->getEntityManager()->getRepository('\Attendance\Entity\Sheet')->getRankingResult($sheetIds);

        return array(
            'sheets'  => $sheets,
            'ranking' => $ranking,
            'totalEvents' => $totalEvents,
        );
    }
}
