<?

class Database
{

  // db connection

  private $db;

  // constructor

  public function __construct($host, $user, $password, $db)
  {
    $mysqli = new mysqli($host, $user, $password, $db);

    //

    if ($mysqli->connect_errno)
    {
      printf("Connect failed: %s\n", $mysqli->connect_error);
      exit();
    }
    else
    {
      $this->db = $mysqli;
    }
  }

  //

  public function mysqli_result($res, $row, $field = 0)
  {
    $res->data_seek($row);
    $datarow = $res->fetch_array();
    return $datarow[$field]; 
  }

  // run modify query

  private function modify($qy, $types = null, $params = null)
  {
    $ret = false;

    //

    if (!empty($this->db))
    {
      if (!empty($types) && !empty($params))
      {
        $stmt = $this->db->prepare($qy);

        // make sure statement is prepared correctly

        if ($stmt)
        {

          $stmt->bind_param($types, ...$params);

          //

          if ($stmt->execute())
          {
            $ret = true;
          }

          //

          $stmt->close();
        }
      }
      elseif ($this->db->query($qy) === true)
      {
        $ret = true;
      }
    }

    //

    return $ret;
  }

	// insert

	public function insert($qy, $types = null, $params = null)
  {
    return $this->modify($qy, $types, $params);
	}
	
	// delete

	public function delete($qy, $types = null, $params = null)
  {
    return $this->modify($qy, $types, $params);
	}
	
	// update

	public function update($qy, $types = null, $params = null)
  {
    return $this->modify($qy, $types, $params);
	}
	
	// select

	public function select($qy)
  {
    $ret = false;

    //

    if (!empty($this->db))
    {
      if ($result = $this->db->query($qy))
      {
        return $result;
      }
    }

    //

    return $ret;
	}

}

?>
