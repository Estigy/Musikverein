<?php

namespace Documents\Controller;

use Application\Controller\BaseController;

use Documents\Entity\Document;
use Documents\Form\DocumentFilterForm;
use Documents\Form\DocumentForm;

use Zend\View\Model\ViewModel;

class DocumentController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $form = new DocumentFilterForm($em);
        if ($form->handleRequest($this->getRequest())) {
            $this->redirect()->toRoute('documents');
        }

        $filters = $form->getFilledValues();

        $entities = $em->getRepository('\Documents\Entity\Document')->getPaginator($filters, 25);

        $page = (int) $this->params()->fromRoute('page', 1);
        $entities->setCurrentPageNumber($page);

        return new ViewModel(array(
            'form' => $form,
            'documents' => $entities
        ));
    }

    public function editAction()
    {
        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id) {
            $entity = $em->find('\Documents\Entity\Document', $id);
            if ($entity === null) {
                return $this->redirect()->toRoute('documents');
            }
        } else {
            $entity = new Document();
        }

        $form = new DocumentForm($em);
        $form->bind($entity);

        if ($entity->id == null) {
            $form->get('submit')->setValue('Hinzufügen');
        };

        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setInputFilter($entity->getInputFilter());
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $form->setData($post);

            if ($form->isValid()) {
                $uploadData = $form->get('upload')->getValue();
                // Wenn eine Datei mitgekommen ist (muss beim Bearbeiten ja nicht sein)
                if ($uploadData['name']) {
                    $entity->filename   = $uploadData['name'];
                    $entity->uploadDate = new \DateTime();
                    $entity->uploadUser = $em->find('\Application\Entity\User', $this->identity()->id);
                    $entity->hash       = hash_file('md5', $uploadData['tmp_name']);
                }

                $em->persist($entity);
                $em->flush();

                if ($uploadData['name']) {
                    $config = $this->getServiceLocator()->get('Config');
                    $path = $config['documents']['upload_path'] . '/' . $entity->id . '.' . $entity->getExtension();
                    move_uploaded_file($uploadData['tmp_name'], $path);
                }
                return $this->redirect()->toRoute('documents');
            }
        }

        return array(
            'id'   => $entity->id ?: 0,
            'form' => $form,
        );
    }

    public function downloadAction()
    {
        $em     = $this->getEntityManager();
        $config = $this->getServiceLocator()->get('Config');

        $hash = $this->params()->fromRoute('hash');
        $entities = $em->getRepository('\Documents\Entity\Document')->findByHash($hash);
        if (empty($entities)) {
            return $this->redirect()->toRoute('documents');
        }
        $entity = $entities[0];

        $response = new \Zend\Http\Response\Stream();
        $response->setStream(fopen($config['documents']['upload_path'] . '/' . $entity->id . '.' . $entity->getExtension(), 'r'));
        $response->setStatusCode(200);

        $contentType = $this->getContentType($entity->getExtension());

        $headers = new \Zend\Http\Headers();
        $headers->addHeaderLine('Content-Type', $contentType)
                ->addHeaderLine('Content-Disposition', 'attachment; filename="' . $entity->filename . '"')
                ->addHeaderLine('Content-Length', filesize($fileName));

        $response->setHeaders($headers);
        return $response;
    }

    protected function getContentType($extension)
    {
        switch (strtolower($extension)) {
            case 'doc':
                return 'application/msword';
            case 'docx':
                return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            case 'txt':
                return 'text/plain';
            case 'pdf':
                return 'application/pdf';
            case 'xls':
                return 'application/vnd.ms-excel';
            case 'xlsx':
                return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            case 'zip':
                return 'application/zip';
            default:
                return 'application/octet-stream';
        }
    }
}

