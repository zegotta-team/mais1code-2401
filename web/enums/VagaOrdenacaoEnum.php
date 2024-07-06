<?php

enum VagaOrdenacaoEnum: string
{
    case MaisRecente = 'id DESC';
    case AlfabeticaCrescente = 'titulo ASC';
}