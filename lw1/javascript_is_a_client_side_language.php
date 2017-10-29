<?php
if (!isset($_GET['how_to_work']) || $_GET['how_to_work'] != 'hard')
{
    header("Status: 400 Work hard!");
}