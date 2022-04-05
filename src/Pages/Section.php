<?php
namespace FilamentPro\Features\Pages;

class Section extends \Filament\Pages\Page
{
    public function mountAction(string $name)
    {
        $this->mountedAction = $name;

        $action = $this->getMountedAction();

        if (! $action) {
            return;
        }

        if ($action->isHidden()) {
            return;
        }

        $this->cacheForm('mountedActionForm');

        app()->call($action->getMountUsing(), [
            'action' => $action,
            'form' => $this->getMountedActionForm(),
        ]);

        if (! $action->shouldOpenModal()) {
            return $this->callMountedAction();
        }

        $this->resetErrorBag();

        $this->dispatchBrowserEvent('open-modal', [
            'id' => static::class . '-action',
        ]);
    }

    public function callMountedAction()
    {
        $action = $this->getMountedAction();

        if (! $action) {
            return;
        }

        if ($action->isHidden()) {
            return;
        }

        $data = $this->getMountedActionForm()->getState();

        $action->call($data);

        $this->dispatchBrowserEvent('close-modal', [
            'id' => static::class . '-action',
        ]);
    }
}
