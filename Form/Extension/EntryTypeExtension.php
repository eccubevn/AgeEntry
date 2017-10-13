<?php

namespace Plugin\AgeEntry\Form\Extension;

use Eccube\Form\Type\Front\EntryType;
use Pimple\Container;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class EntryTypeExtension
 * @package Plugin\AgeEntry\Form\Extension
 */
class EntryTypeExtension extends AbstractTypeExtension
{
    /**
     * @var array
     */
    public $appConfig;

    /**
     * EntryTypeExtension constructor.
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->appConfig = $app['config'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();
            if (!isset($data['birth']) || empty($data['birth'])) {
                return;
            }
            $birthday = $data['birth'];
            $now = new \DateTime();
            $interval = $now->diff($birthday);

            // TODO: Creates age constants after because the core code error when creating constants.
            $maxAge = 20;
            if ($interval->y < $maxAge) {
                // TODO: add to resource/locale/message.xxx after core code releases.
                $form['birth']->addError(new FormError("※ 登録するには{$maxAge}歳以上でなければなりません。"));
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return EntryType::class;
    }
}
