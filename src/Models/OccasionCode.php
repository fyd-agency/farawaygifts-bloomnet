<?php namespace BloomNetwork\Models;

enum OccasionCode: int
{
    case Funeral_Memorial = 1;
    case Illness = 2;
    case Birthday = 3;
    case Business = 4;
    case Holiday = 5;
    case Maternity = 6;
    case Anniversary = 7;
    case Others = 8;
}