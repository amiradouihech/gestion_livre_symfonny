<?php

namespace App\Form;
use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_commande')
            ->add('utilisateur')
            ->add('no')
            ->add('adresse_livraison')
            ->add('total')
            ->add('mode_paiement')
            ->add('frais_livrasion')
            ->add('remis')
            ->add('note')
            ->add('numero_tracking')
            ->add('transporteur')
            ->add('date_livraison')
            ->add('adresse_facturation')
            ->add('email')
            ->add('telephone')
            ->add('Enregistrer',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
