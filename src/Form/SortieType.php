<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, [
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'required' => true,
                'label' => 'Date et heure de la sortie'
            ])
            ->add('dateLimiteInscription', DateTimeType::class, [
                'required' => true,
                'label' => 'Date limite d\'inscription'
            ])
            ->add('nbInscriptionMax',IntegerType::class, [
                'required' => true,
                'label' => 'Nombre de places'
            ])
            ->add('duree', IntegerType::class, [
                'required' => true,
                'label' => 'Durée'
            ])
            ->add('infosSortie', TextType::class, [
                'required' => true,
                'label' => 'Description et infos'
            ])
            ->add('campus', EntityType::class, [
                'class'=> Campus::class,
                'choice_label' => 'nom'
            ])
            ->add('lieu', EntityType::class, [
                'class'=> Lieu::class,
                'choice_label' => 'nom'
            ])
            ->add('latitude', EntityType::class, [
                'class'=> Lieu::class,
                'mapped'=> false,
                'disabled' => true,
                'choice_label' => function ($lieu) {
                    return $lieu->getLatitude();
                }
            ])
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'libelle',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('entite')->orderBy('entite.libelle', 'ASC');}
                ])
            ->add('Valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
