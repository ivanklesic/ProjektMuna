<?php declare(strict_types = 1);

namespace App\Core\Service;

class CheckStringService {

    const ARRAY_X = ['a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U'];
    const ARRAY_BAGUETTE = [
        ['b', 'B'],
        ['a', 'A'],
        ['g', 'G'],
        ['u', 'U'],
        ['e', 'E'],
        ['t', 'T'],
        ['t', 'T'],
        ['e', 'E']
    ];

    public function check(string $value)
    {
        $valueLength = strlen($value);

        if ($valueLength < 2){
            return 'String is too short';
        } else if ($valueLength > 100) {
            return 'String is too long';
        }

        $valueArray = str_split($value);

        if (!in_array($valueArray[0], self::ARRAY_X)) {
            if ($valueArray[$valueLength - 1] === '!'){
                return true;
            }
        } else {
            if (in_array($valueArray[1], self::ARRAY_X)) {
                if($valueLength === 2) {
                    return true;
                }
                $countBaguette = 0;
                for ($i = 2;$i <= $valueLength - 1;$i++) {
                    if (!$countBaguette) {
                        if (in_array($valueArray[$i], self::ARRAY_X)) {
                            if($i == $valueLength - 1) {
                                return true;
                            }
                        } else {
                            if (in_array($valueArray[$i], self::ARRAY_BAGUETTE[0])) {
                                ++$countBaguette;
                            } else {
                                return false;
                            }
                        }
                    } else {
                        if ($valueArray[$i] === '#' || in_array($valueArray[$i], self::ARRAY_BAGUETTE[$countBaguette])) {
                            if(in_array($valueArray[$i], self::ARRAY_BAGUETTE[$countBaguette])) {
                                ++$countBaguette;
                            }
                            if ($countBaguette === 8) {
                                return true;
                            }
                            continue;
                        }
                        return false;
                    }
                }
            }
        }
        return false;
    }
}

