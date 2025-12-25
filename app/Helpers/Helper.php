
<?php

function getSpecialtyIcon($specialtyName)
{
    switch ($specialtyName) {
        case 'Cardiology':
            return 'fa-heart-pulse';
        case 'Neurology':
            return 'fa-brain';
        case 'Oncology':
            return 'fa-ribbon';
        case 'Pediatrics':
            return 'fa-child';
        case 'Dermatology':
            return 'fa-user';
        case 'Orthopedics':
            return 'fa-bone';
        case 'Gynecology':
            return 'fa-female';
        case 'General Medicine':
            return 'fa-stethoscope';
        case 'Ophthalmology':
            return 'fa-eye';
        case 'Psychiatry':
            return 'fa-head-side-brain';
        default:
            return 'fa-medkit';
    }
}