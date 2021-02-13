<?php

/* Given an array of integers, return indices of the two numbers such that they add up to a specific target.
 You may assume that each input would have exactly one solution, and you may not use the same element twice.


 Example:

 Given nums = [2, 7, 11, 15], target = 9,

 Because nums[0] + nums[1] = 2 + 7 = 9,
 return [0, 1].

*/
function returnIndeces(array $numbers, int $target) :string | array
{
    // const NUM = 3;
    $len = count($numbers) - 1;
    for($i = 0; $i <= $len; $i++){
        for($j = $i + 1; $j <= $len; $j++){
            $sum = $numbers[$i] + $numbers[$j];

            if ($sum === $target){
                return [$i, $j];
            }
        }
    }
    return "No matching numbers\n";
}


$nums = [2, 7, 11, 15];
print_r(returnIndeces($nums, 14));

