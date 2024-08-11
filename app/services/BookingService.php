<?php

namespace App\services;

class BookingService
{
	const SINGLE_ROOM_RATE = 1500;
	const DOUBLE_ROOM_RATE = 2000;
	const TRIPLE_ROOM_RATE = 2750;
	const EXTRA_BED_RATE   = 500;
	
	protected int $singleRooms;
	protected int $doubleRooms;
	protected int $tripleRooms;
	protected int $extraBeds;

//	public function calculateRooms($adults, $childrenUnder13)
//	{
//		$this->singleRooms = 0;
//		$this->doubleRooms = 0;
//		$this->tripleRooms = 0;
//		$this->extraBeds = 0;
//
//		// Allocate rooms for adults
//		while ($adults >= 2 && $childrenUnder13 > 0) {
//			$this->doubleRooms++;
//			$this->extraBeds++;
//			$adults -= 2;
//			$childrenUnder13--;
//		}
//
//		while ($adults >= 1 && $childrenUnder13 > 0) {
//			$this->singleRooms++;
//			$this->extraBeds++;
//			$adults--;
//			$childrenUnder13--;
//		}
//
//		while ($adults >= 1) {
//			$this->singleRooms++;
//			$adults--;
//		}
//
//		// Allocate rooms for remaining children
//		while ($childrenUnder13 > 0) {
//			if ($childrenUnder13 >= 3) {
//				$this->tripleRooms++;
//				$childrenUnder13 -= 3;
//			} else if ($childrenUnder13 >= 2) {
//				$this->doubleRooms++;
//				$childrenUnder13 -= 2;
//			} else {
//				$this->singleRooms++;
//				$childrenUnder13--;
//			}
//		}
//
//		return [
//			"singleRooms" => $this->singleRooms,
//			"doubleRooms" => $this->doubleRooms,
//			"tripleRooms" => $this->tripleRooms,
//			"extraBeds"   => $this->extraBeds,
//		];
//	}
//	public function calculateCost(int $numberOfNight)
//	{
//		$cost = $this->singleRooms * self::SINGLE_ROOM_RATE;
//		$cost += $this->doubleRooms * self::DOUBLE_ROOM_RATE;
//		$cost += $this->tripleRooms * self::TRIPLE_ROOM_RATE;
//		$cost += $this->extraBeds * self::EXTRA_BED_RATE;
//		$cost *= $numberOfNight;
//		return $cost;
//	}
	
	public function calculateRooms(int $adults, int $childrenUnder13)
	{
		$dp = [];
		$allocation = [];
		
		// Initialize DP table
		for ($a = 0; $a <= $adults; $a++) {
			for ($c = 0; $c <= $childrenUnder13; $c++) {
				$dp[ $a ][ $c ] = PHP_INT_MAX;
				$allocation[ $a ][ $c ] = [ 0, 0, 0, 0 ]; // [single, double, triple, extra]
			}
		}
		$dp[0][0] = 0;
		
		// Fill DP table with all possible combinations
		for ($a = 0; $a <= $adults; $a++) {
			for ($c = 0; $c <= $childrenUnder13; $c++) {
				// Allocate single room
				if ($a > 0) {
					$cost = $dp[ $a - 1 ][ $c ] + self::SINGLE_ROOM_RATE;
					if ($cost < $dp[ $a ][ $c ]) {
						$dp[ $a ][ $c ] = $cost;
						$allocation[ $a ][ $c ] = [ $allocation[ $a - 1 ][ $c ][0] + 1, $allocation[ $a - 1 ][ $c ][1], $allocation[ $a - 1 ][ $c ][2], $allocation[ $a - 1 ][ $c ][3] ];
					}
				}
				// Allocate double room
				if ($a > 1) {
					$cost = $dp[ $a - 2 ][ $c ] + self::DOUBLE_ROOM_RATE;
					if ($cost < $dp[ $a ][ $c ]) {
						$dp[ $a ][ $c ] = $cost;
						$allocation[ $a ][ $c ] = [ $allocation[ $a - 2 ][ $c ][0], $allocation[ $a - 2 ][ $c ][1] + 1, $allocation[ $a - 2 ][ $c ][2], $allocation[ $a - 2 ][ $c ][3] ];
					}
				}
				// Allocate triple room
				if ($a > 2) {
					$cost = $dp[ $a - 3 ][ $c ] + self::TRIPLE_ROOM_RATE;
					if ($cost < $dp[ $a ][ $c ]) {
						$dp[ $a ][ $c ] = $cost;
						$allocation[ $a ][ $c ] = [ $allocation[ $a - 3 ][ $c ][0], $allocation[ $a - 3 ][ $c ][1], $allocation[ $a - 3 ][ $c ][2] + 1, $allocation[ $a - 3 ][ $c ][3] ];
					}
				}
				// Allocate double room with extra bed
				if ($a > 1 && $c > 0) {
					$cost = $dp[ $a - 2 ][ $c - 1 ] + self::DOUBLE_ROOM_RATE + self::EXTRA_BED_RATE;
					if ($cost < $dp[ $a ][ $c ]) {
						$dp[ $a ][ $c ] = $cost;
						$allocation[ $a ][ $c ] = [ $allocation[ $a - 2 ][ $c - 1 ][0], $allocation[ $a - 2 ][ $c - 1 ][1] + 1, $allocation[ $a - 2 ][ $c - 1 ][2], $allocation[ $a - 2 ][ $c - 1 ][3] + 1 ];
					}
				}
				// Allocate single room with extra bed
				if ($a > 0 && $c > 0) {
					$cost = $dp[ $a - 1 ][ $c - 1 ] + self::SINGLE_ROOM_RATE + self::EXTRA_BED_RATE;
					if ($cost < $dp[ $a ][ $c ]) {
						$dp[ $a ][ $c ] = $cost;
						$allocation[ $a ][ $c ] = [ $allocation[ $a - 1 ][ $c - 1 ][0] + 1, $allocation[ $a - 1 ][ $c - 1 ][1], $allocation[ $a - 1 ][ $c - 1 ][2], $allocation[ $a - 1 ][ $c - 1 ][3] + 1 ];
					}
				}
				// Allocate triple room with extra bed
				if ($a > 2 && $c > 0) {
					$cost = $dp[ $a - 3 ][ $c - 1 ] + self::TRIPLE_ROOM_RATE + self::EXTRA_BED_RATE;
					if ($cost < $dp[ $a ][ $c ]) {
						$dp[ $a ][ $c ] = $cost;
						$allocation[ $a ][ $c ] = [ $allocation[ $a - 3 ][ $c - 1 ][0], $allocation[ $a - 3 ][ $c - 1 ][1], $allocation[ $a - 3 ][ $c - 1 ][2] + 1, $allocation[ $a - 3 ][ $c - 1 ][3] + 1 ];
					}
				}
				// Allocate double room for children only
				if ($c > 1) {
					$cost = $dp[ $a ][ $c - 2 ] + self::DOUBLE_ROOM_RATE;
					if ($cost < $dp[ $a ][ $c ]) {
						$dp[ $a ][ $c ] = $cost;
						$allocation[ $a ][ $c ] = [ $allocation[ $a ][ $c - 2 ][0], $allocation[ $a ][ $c - 2 ][1] + 1, $allocation[ $a ][ $c - 2 ][2], $allocation[ $a ][ $c - 2 ][3] ];
					}
				}
				// Allocate triple room for children only
				if ($c > 2) {
					$cost = $dp[ $a ][ $c - 3 ] + self::TRIPLE_ROOM_RATE;
					if ($cost < $dp[ $a ][ $c ]) {
						$dp[ $a ][ $c ] = $cost;
						$allocation[ $a ][ $c ] = [ $allocation[ $a ][ $c - 3 ][0], $allocation[ $a ][ $c - 3 ][1], $allocation[ $a ][ $c - 3 ][2] + 1, $allocation[ $a ][ $c - 3 ][3] ];
					}
				}
			}
		}
		
		// Extract final room allocation
		[ $this->singleRooms, $this->doubleRooms, $this->tripleRooms, $this->extraBeds ] = $allocation[ $adults ][ $childrenUnder13 ];
		
		return [
			"SINGLE_ROOM" => $this->singleRooms,
			"DOUBLE_ROOM" => $this->doubleRooms,
			"TRIPLE_ROOM" => $this->tripleRooms,
			"EXTRA_BED"   => $this->extraBeds,
		];
	}
	
	public function calculateCost(int $numberOfNights): int
	{
		$cost = $this->singleRooms * self::SINGLE_ROOM_RATE;
		$cost += $this->doubleRooms * self::DOUBLE_ROOM_RATE;
		$cost += $this->tripleRooms * self::TRIPLE_ROOM_RATE;
		$cost += $this->extraBeds * self::EXTRA_BED_RATE;
		$cost *= $numberOfNights;
		
		return $cost;
	}
	
	
	public function calculateAdultsAndChildren($guest_age): array
	{
		$adults = 0;
		$childrenUnder13 = 0;
		foreach ($guest_age as $age) {
			if ($age >= 13) {
				$adults++;
			} else if ($age >= 5) {
				$childrenUnder13++;
			}
		}
		return [ $adults, $childrenUnder13 ];
	}
	
}


// test case

//$bookingService = new BookingService();
//print_r($bookingService->calculateRooms(4, 5));
//print_r($bookingService->calculateCost(1));
