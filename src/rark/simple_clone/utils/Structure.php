<?php

declare(strict_types = 1);

namespace rark\simple_clone\utils;

use pocketmine\level\{
	Level,
	particle\Particle
};
use pocketmine\utils\{
	Config,
	UUID
};
use pocketmine\math\Vector3;


class Structure{
	private static array $structures = [];
	protected array $blocks = [];
	protected $v1;
	protected $v2;

	public function __construct(){
		$this->v1 = new Vector3;
		$this->v2 = new Vector3;
	}

	public function load(string $dir, string $file):bool{
		$path = $dir.'/'.$file;
		if(!file_exists($path)) return false;
		$conf = new Config($path, Config::JSON);
		$blocks = [];

		foreach($conf->getAll() as $str_diff => $str_block){
			$dat = explode('&&&', $str_block);

			if(count($dat)!==2) return false;
			$block = Block::get($dat[0]);
			$block->setDamage($dat[1]);
			$blocks[$str_diff] = $block;
		}
		$this->blocks = $blocks;
		return true;
	}

	public function save(string $dir, ?string $file = null):void{
		$file = $file===null? UUID::fromRandom()->toString(): $file;
		$path = $dir.'/'.$file;
		$conf = new Config($path, Config::JSON);

		foreach($this->blocks as $str_diff => $block){
			$conf->set($str_diff, $block->getId().'&&&'.$block->getDamage());
		}
		$conf->save();
	}

	public function copy(Level $level):void{
		for($x = $this->v2->x-$this->v1->x; $x>=0; --$x){
			for($y = $this->v2->y-$this->v1->y; $y>=0; --$y){
				for($z = $this->v2->z-$this->v1->z; $z>=0; --$z){
					$v = $this->v1->add($x, $y, $z);
					$this->blocks[Utility::serializeVector(Utility::getDiff($v, $this->v1))] = $level->getBlock($v);
				}
			}
		}
	}

	public function resize(?Vector3 $v1 = null, ?Vector3 $v2 = null):void{
		$v1 = $v1===null? $this->v1: $v1;
		$v2 = $v2===null? $this->v2: $v2;
		Utility::sortVector($v1, $v2);
		$this->v1 = $v1;
		$this->v2 = $v2;
	}

	public function showOutLine(Level $level, Particle $particle):void{
		$xv1 = new Vector3($this->v1->x, $this->v1->y, $this->v2->z);
		$xv2 = new Vector3($this->v1->x, $this->v2->y, $this->v1->z);
		$yv1 = new Vector3($this->v1->x, $this->v1->y, $this->v2->z);
		$yv2 = new Vector3($this->v2->x, $this->v2->y, $this->v1->z);
		$zv1 = new Vector3($this->v1->x, $this->v2->y, $this->v1->z);
		$zv2 = new Vector3($this->v2->x, $this->v1->y, $this->v1->z);
		$add_particle = function(Vector3 $v1, Vector3 $v2, Vector3 $v3, Vector3 $v4) use($level, $particle):void{
			$level->addParticle($particle->setComponents($v1->x, $v1->y, $v1->z));
			$level->addParticle($particle->setComponents($v2->x, $v2->y, $v2->z));
			$level->addParticle($particle->setComponents($v3->x, $v3->y, $v3->z));
			$level->addParticle($particle->setComponents($v4->x, $v4->y, $v4->z));
		};

		for($diff = $this->v2->x-$this->v1->x; $diff>-1; --$diff){
			$add_particle(
				$this->v1->add($diff, 0, 0),
				$xv1->add($diff, 0, 0),
				$xv2->add($diff, 0, 0),
				$this->v2->subtract($diff, 0, 0)
			);
		}
		for($diff = $this->v2->y-$this->v1->y; $diff>-1; --$diff){
			$add_particle(
				$this->v1->add(0, $diff, 0),
				$yv1->add(0, $diff, 0),
				$yv2->add(0, $diff, 0),
				$this->v2->subtract(0, $diff, 0)
			);
		}
		for($diff = $this->v2->x-$this->v1->x; $diff>-1; --$diff){
			$add_particle(
				$this->v1->add(0, 0, $diff),
				$zv1->add(0, 0, $diff),
				$zv2->add(0, 0, $diff),
				$this->v2->subtract(0, 0, $diff)
			);
		}
	}

	public function paste(Vector3 $min_vector):void{}//todo
}