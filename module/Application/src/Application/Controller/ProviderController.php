<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Provider;

class ProviderController extends AbstractActionController
{
    protected $_objectManager;

    public function indexAction()
    {
        $providers = $this->getObjectManager()->getRepository('\Application\Entity\Provider')->findAll();

        return new ViewModel(array('providers' => $providers));
    }

    public function addAction()
    {
        if ($this->request->isPost()) {
            $provider = new Provider();
            $provider->setFullName($this->getRequest()->getPost('fullname'));

            $this->getObjectManager()->persist($provider);
            $this->getObjectManager()->flush();
            $newId = $provider->getId();

            return $this->redirect()->toRoute('home');
        }
        return new ViewModel();
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $provider = $this->getObjectManager()->find('\Application\Entity\Provider', $id);

        if ($this->request->isPost()) {
            $provider->setFullName($this->getRequest()->getPost('fullname'));

            $this->getObjectManager()->persist($provider);
            $this->getObjectManager()->flush();

            return $this->redirect()->toRoute('home');
        }

        return new ViewModel(array('provider' => $provider));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $provider = $this->getObjectManager()->find('\Application\Entity\Provider', $id);

        if ($this->request->isPost()) {
            $this->getObjectManager()->remove($provider);
            $this->getObjectManager()->flush();

            return $this->redirect()->toRoute('home');
        }

        return new ViewModel(array('provider' => $provider));
    }

    protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->_objectManager;
    }
}