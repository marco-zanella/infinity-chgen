<?php



class ByteArray {
	public function __construct(array $data = null)
	{
		$this->_data = $data;
		$this->_size = count($data);
	}


	public function copy()
	{
		return $this->slice(1, $this->_size);
	}


	public function raw()
	{
	    $bin = function ($carry, $item) { return $carry . pack("C", $item); };
	    return array_reduce($this->_data, $bin);
	}


	public function getSize()
	{
		return $this->_size;
	}


	public function slice($start, $length)
	{
		return new ByteArray(array_slice($this->_data, $start, $length));
	}


	public function get($offset)
	{
		return $this->slice($offset, 1);
	}


	public function set($offset, $value)
	{
		$this->_data[$offset + 1] = $value;
		return $this;
	}


	public function setString($offset, $string)
	{
		$string = sprintf("%s%c", $string, '\0');
		$chars = str_split($string);
		for ($i = 0; $i < count($chars); ++$i) {
			$this->set($offset + $i, ord($chars[$i]));
		}
		return $this;
	}


	public function toString()
	{
		$ascii = function ($c) { return sprintf("%c", $c); };
		return implode("", array_map($ascii, $this->_data));
	}


	public function toInt()
	{
		$parse = function ($carry, $item) { return $carry * 8 + $item; };
		return array_reduce(array_reverse($this->_data), $parse);
	}


	public static function read($filename)
	{
		$fh = fopen($filename, 'rb');
		$size = filesize($filename);
		$content = fread($fh, $size);
		$data = unpack("C*", $content);
		fclose($fh);

		return new ByteArray($data);
	}

	public function write($filename)
	{
		$bin = function ($carry, $item) { return $carry . pack("C", $item); };
		$fh = fopen($filename, 'wb');
		$data = array_reduce($this->_data, $bin);
		fwrite($fh, $data);
		fclose($fh);

		return $this;
	}


	private $_data;
	private $_size;
}
