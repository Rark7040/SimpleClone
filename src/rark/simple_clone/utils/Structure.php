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

	use Utility;

	private static array $structures = [];
	protected bool $useable = false;
	protected array $blocks = [];
	protected string $name;
	protected string $id;
	/** @var pocketmine\math\Vector3 min vector */
	protected $v1;
	/** @var pocketmine\math\Vector3 max vector */
	protected $v2;

	public function __construct(string $name){
		$this->name = $name;
		$this->id = UUID::fromRandom()->toString();
		$this->v1 = new Vector3;
		$this->v2 = new Vector3;
	}

	/**
	 * ストラクチャが使用可能か検証します
	 * @return bool
	 */
	public function init():bool{
		$this->usable = !isset(self::$structures[$this->name]) or self::$structures[$this->name]->getId()!==$this->id;
		return $this->usable;
	}

	/**
	 * 使用可能なストラクチャのオブジェクトを返します
	 * @return self[]
	 */
	public static function getStructures():array{
		return self::$structures;
	}

	/**
	 * ストラクチャ名を返します
	 */
	public function getName():string{
		return $this->name;
	}

	/**
	 * UUIDを返します
	 */
	public function getId():string{
		return $this->id;
	}

	/**
	 * テキストアーカイブからストラクチャのオブジェクトを抽出します
	 * また、その抽出されたデータはこのクラスのインスタンスを上書きします
	 * @return bool <true=success|false=failed>
	 */
	public function load(string $file):bool{
		$path = Main::getDataPath().$file;

		if(!file_exists($path) or strrchr($file, '.')==='.scstr') return false;
		$conf = new Config($path, Config::JSON);
		$blocks = [];

		foreach($conf->get() as $str_diff => $str_block){
			$dat = explode('&&&', $str_block);

			if(count($dat)!==2) return false;
			$block = Block::get($dat[0]);
			$block->setDamage($dat[1]);
			$blocks[$str_diff] = $block;
		}
		$this->blocks = $blocks;
		return true;
	}

	/**
	 * 現在のインスタンスをテキストアーカイブとしてプラグインのデータフォルダに保存します
	 */
	public function save():void{
		$path = Main::getDataPath().$this->name.$this->id.'.scstr';
		$conf = new Config($path, Config::JSON);
		$conf->set('name', $this->name);
		$conf->set('id', $this->id);

		foreach($this->blocks as $str_diff => $block){
			$conf->set($str_diff, $block->getId().'&&&'.$block->getDamage());
		}
		$conf->save();
	}

	/**
	 * メンバ変数v1、v2に格納されているVector3の範囲内のブロックデータを取得します
	 * @return bool <true=success|false=failed>
	 */
	public function copy(Level $level):bool{
		if(!$this->v1 instanceof Vector3 or !$this->v2 instanceof Vector3) return false;
		for($x = $this->v2->x-$this->v1->x; $x>=0; --$x){
			for($y = $this->v2->y-$this->v1->y; $y>=0; --$y){
				for($z = $this->v2->z-$this->v1->z; $z>=0; --$z){
					$v = $this->v1->add($x, $y, $z);
					$this->blocks[self::serializeVector(self::getDiff($v, $this->v1))] = $level->getBlock($v);
				}
			}
		}
		return true;
	}

	/**
	 * メンバ変数、v1、v2にVector3を格納します
	 */
	public function resize(?Vector3 $v1 = null, ?Vector3 $v2 = null):void{
		$v1 = $v1===null? $this->v1: $v1;
		$v2 = $v2===null? $this->v2: $v2;
		self::sortVector($v1, $v2);
		$this->v1 = $v1;
		$this->v2 = $v2;
	}

	/**
	 * メンバ変数、v1、v2の範囲をパーティクルで表示します
	 */
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