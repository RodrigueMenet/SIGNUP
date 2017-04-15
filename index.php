<?php

// @author : RODRIGUE MENET

/*************************************************
 * TRAD MANAGER
 *************************************************/
 
	/**
	 * Singleton class, main use is to  
	 * know in which preferred 
	 * language browser is set
	 * @author rodrigue.menet
	 *
	 */
	class Lang {
    	/**
    	 * TODO 
    	 * put it on auto-generated from cvs include file 
    	 */
    	const E_LANG_EN = 0;
    	const E_LANG_FR = 1;
    	const E_LANG_MAX = 2;
    	
		/**
		 * private constructor (singleton)
		 */
		private function __construct () {}
	 
		/**
		 * clone forbidden (singleton)
		 */
		private function __clone () {}
	 
		private static $instance;
		/**
		 * Even getinstance is private, it is called in public static method
		 */
		private static function getInstance () {
			if (!(self::$instance instanceof self)) {
    			self::$instance = new self();
    		}
			return self::$instance;
		}
		
		private $miLng = self::E_LANG_EN;
    	
		public static function setLang($iLng) {
			self::getInstance()->miLng = $iLng;
		}
		
		public static function getLang() {
			return self::getInstance()->miLng;
		}
		
		public static function htmlEncode($sValue) {
			return htmlentities($sValue, ENT_COMPAT, "ISO-8859-1");
		}
    }
    
    /**
     * Singleton class, main use is to
     * know manage all vocabulary
     * @author rodrigue.menet
     *
     */
    class Trad {
    	
    	/**
    	 * ENUM TRAD --> TODO put it on auto-generated from cvs include file 
    	 */
    	const E_TRAD_WELCOME = 0;
    	const E_TRAD_SUBMIT = 1;
    	const E_TRAD_RESET = 2;
    	const E_TRAD_USERLIST = 3;
		const E_TRAD_NAME = 4;
		const E_TRAD_AGE = 5;
		const E_TRAD_WARN_NAME = 6;
		const E_TRAD_WARN_AGE = 7;
		const E_TRAD_WARN_AGE_DOWN = 8;
		const E_TRAD_WARN_AGE_UP = 9;		

    	/**
    	 * ENUM TRAD --> TODO put it on auto-generated from cvs include file
    	 */
    	private static $sTrads = array (
    		self::E_TRAD_WELCOME => array (
    				Lang::E_LANG_EN => "Welcome you !! Please register", 
    				Lang::E_LANG_FR => "Bonjour à toi !! Incris-toi ci-dessous"
    		),
    		self::E_TRAD_SUBMIT => array (
    				Lang::E_LANG_EN => "Submit", 
    				Lang::E_LANG_FR => "Soumettre"
    		),
    		self::E_TRAD_RESET => array (
    				Lang::E_LANG_EN => "Reset",
    				Lang::E_LANG_FR => "Réinitialiser"
    		),
    		self::E_TRAD_USERLIST => array (
    				Lang::E_LANG_EN => "Users list",
    				Lang::E_LANG_FR => "Liste utilisateurs"
    		),
    		self::E_TRAD_NAME => array (
    				Lang::E_LANG_EN => "User", 
    				Lang::E_LANG_FR => "Utilisateur"
    		),
    		self::E_TRAD_AGE => array (
    				Lang::E_LANG_EN => "Age", 
    				Lang::E_LANG_FR => "Age"
    		),
    		self::E_TRAD_WARN_NAME => array (
    				Lang::E_LANG_EN => "Please enter a name", 
    				Lang::E_LANG_FR => "Veuillez entrer un nom"
    		),
    		self::E_TRAD_WARN_AGE => array (
    				Lang::E_LANG_EN => "Please enter an age", 
    				Lang::E_LANG_FR => "Veuillez entrer un âge"
    		),
    		self::E_TRAD_WARN_AGE_UP => array (
    				Lang::E_LANG_EN => "Nobody can be so old !", 
    				Lang::E_LANG_FR => "Personne ne peut avoir cet âge !"
    		),
    		self::E_TRAD_WARN_AGE_DOWN => array (
    				Lang::E_LANG_EN => "Submit forbidden, too young", 
    				Lang::E_LANG_FR => "Inscription interdite, trop jeune"
    		)
    	);
    	/**
    	 * Get Trad in the right language
    	 * @param integer $iTradId
    	 * @return string
    	 */
		public static function getTrad($iTradId, $bHtmlEncode = true) {
			if (Lang::getLang() >= Lang::E_LANG_MAX || Lang::getLang() < 0) {
				return "ERROR : Unknown language id : ".Lang::getLang();
			}
			if ($iTradId >= sizeof(self::$sTrads) || $iTradId < 0) {
				return "ERROR : Unknown trad id : ".$iTradId;
			}
			if (Lang::getLang() >= sizeof(self::$sTrads[$iTradId])) {
				return "ERROR : Unknow lang id : ".Lang::getLang()." for "." traduction";
			}
			$trad = self::$sTrads[$iTradId][Lang::getLang()];
			return $bHtmlEncode ? Lang::htmlEncode($trad) : utf8_encode($trad);
		}
    }
    
    /*************************************************
     * MAIN CLASS
     *************************************************/
    /**
     * User is the main class, to manipulate both attributes
     * Name and age
     * @author rodrigue.menet
     *
     */
    class User {
	
		const I_USER_OLD = 158;
		const I_USER_YOUNG = 3;
    	
    	private $msName = 'NameNotSet';
    	private $miAge = -1;

    	public function __construct ($sName, $iAge) {
    		$this->msName = $sName;
    		$this->miAge = $iAge;
    	}
    	
    	/**
    	 * No setters (only constructor)
    	 */
    	public function getName() {
    		return $this->msName;
    	}    	
    	public function getAge() {
    		return $this->miAge;
    	}
    	
    	/**
    	 * To automatically echo
    	 * @return string
    	 */
    	public function __toString() {
    		return "<tr>
						<td>".Lang::htmlEncode(utf8_decode($this->getName()))."</td>
						<td>".Lang::htmlEncode(utf8_decode($this->getAge()))."</td>
					</tr>";
    	}
    }
    
    /**
     * User manager is here to manage all users
     * @author rodrigue.menet
     *
     */
    class UserManager {
	
		const S_SESSION_USERS = 'users';
		
		/**
		 * Add new user in session
		 * @param unknown $oUser
		 */
    	public static function addUser($oUser) {
			session_start();
			if (!isset($_SESSION[self::S_SESSION_USERS])) {
				$_SESSION[self::S_SESSION_USERS] = array();
			}
			array_push($_SESSION[self::S_SESSION_USERS], $oUser);
    	}
    	
    	/**
    	 * build actual table with all users
    	 */
    	public static function displayUsers() {
			echo "<table id='usertable'>";
			echo "<caption>".Trad::getTrad(Trad::E_TRAD_USERLIST)."</caption>";
			echo "<tr>";
			echo "<th>".Trad::getTrad(Trad::E_TRAD_NAME)."</th>";
			echo "<th>".Trad::getTrad(Trad::E_TRAD_AGE)."</th>";
			echo "</tr>";
			if (isset($_SESSION[self::S_SESSION_USERS])) {
				foreach($_SESSION[self::S_SESSION_USERS] as $oUser) {
					echo $oUser;
				}
			}
			echo "</table>";
    	}
		
		/**
		 * reset session, then users
		 */
    	public static function resetUsers() {
			session_start();
			if (isset($_SESSION[self::S_SESSION_USERS])) {
				unset($_SESSION[self::S_SESSION_USERS]);
			}
			session_destroy();
		}
    }
    /*************************************************
     * UNIT TEST MANAGER
     *************************************************/
	 /*
    Lang::setLang(Lang::E_LANG_EN);
    echo Trad::getTrad(Trad::E_TRAD_WELCOME)."<br/>";
    echo Trad::getTrad(Trad::E_TRAD_LOGOK)."<br/>";;
	echo Trad::getTrad(16)."<br/>";
	echo Trad::getTrad(-1)."<br/>";
    Lang::setLang(Lang::E_LANG_FR);
    echo Trad::getTrad(Trad::E_TRAD_WELCOME)."<br/>";
    echo Trad::getTrad(Trad::E_TRAD_LOGOK)."<br/>";
	echo Trad::getTrad(16)."<br/>";
	echo Trad::getTrad(-1)."<br/>";
	Lang::setLang(15);
	echo Trad::getTrad(Trad::E_TRAD_WELCOME)."<br/>";
    echo Trad::getTrad(Trad::E_TRAD_LOGOK)."<br/>";
	echo Trad::getTrad(16)."<br/>";
	echo Trad::getTrad(-1)."<br/>";

	UserManager::addUser(new User("Rod", 29));
    UserManager::addUser(new User("RodOlderGuy", 30));
	UserManager::displayUsers();
	UserManager::resetUsers();
	UserManager::displayUsers();
	*/
	/*************************************************
     * MAIN
     *************************************************/
    if (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) === 'fr') {
    	Lang::setLang(Lang::E_LANG_FR);
    } else {
    	Lang::setLang(Lang::E_LANG_EN);
    }
    
	 // if we have an action it is ajax
	if (isset($_GET["action"])) {

		switch ($_GET["action"]) {
			case "add":
				if (isset($_GET["name"]) && isset($_GET["age"])) {
					UserManager::addUser(new User(urldecode($_GET["name"]), urldecode($_GET["age"])));
					UserManager::displayUsers();
				}
				break;
			case "reset":
				UserManager::resetUsers();
				UserManager::displayUsers();
				break;
			default:
				echo "Unknown action";
				break;
		}
	} else {
		// initial loading
		?>
	<BODY>
		<HEAD>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<script>
			// to add some functionality later
			function openAlert(sMess) {
				alert(sMess);
			}
			
			function setFocus() {
				document.getElementById('name').focus();
			}
			// to create ajax object
			function createXhrObject() {
				if (window.XMLHttpRequest) {
					return new XMLHttpRequest();
				}

				if (window.ActiveXObject) {
					var sNames = [
						"Msxml2.XMLHTTP.6.0",
						"Msxml2.XMLHTTP.3.0",
						"Msxml2.XMLHTTP",
						"Microsoft.XMLHTTP"
					];
					for(var n in sNames) {
						try{
							return new ActiveXObject(sNames[n]);
						}
						catch(e){}
					}
				}
				openAlert("Your internet browser does not support XMLHTTPRequest.");
				return null; // not supported
			}
			
			// generic function to call ajax with callback
			// callback is called with responsetext
			function ajax(sUrl, fnCallback) {
				var xhr = createXhrObject();
				xhr.open("GET", sUrl);
				// callback
				xhr.onreadystatechange = function () {
					if (xhr.readyState == 4 && xhr.status == 200) {
						// got response
						fnCallback(xhr.responseText);
						delete xhr;
					}
				};
				xhr.send();
			}

			// IE does not support innerhtml dynamically set
			function fixIEInnerHTML(tbody, value) {
				var temp = tbody.ownerDocument.createElement('div');
				temp.innerHTML = value;
				tbody.parentNode.replaceChild(temp.firstChild, tbody);
			}
			
			function refresh(value) {
				var table = document.getElementById('usertable');
				// not supported by IE...
				try {
					table.innerHTML = value;
				} catch (e) {
					fixIEInnerHTML(table, value);
				}
				setFocus();
			}
			
			function addUser(sName, iAge) {
				ajax("index.php?action=add&name="+encodeURIComponent(sName)+"&age="+encodeURIComponent(iAge),
					refresh);
			}
			
			function reset() {
				ajax("index.php?action=reset",
						refresh);
			}
			
			function isNumeric(n) {
				return !isNaN(parseFloat(n)) && isFinite(n);
			}
			
			function onSubmitClicked() {
				var sName = document.getElementById("name").value;
				var sAge = document.getElementById("age").value;
				
				if (sName == '') {
					openAlert("<?php echo Trad::getTrad(Trad::E_TRAD_WARN_NAME, false);?>");
				} else if (sAge == '' || !isNumeric(sAge)) {
					openAlert("<?php echo Trad::getTrad(Trad::E_TRAD_WARN_AGE, false);?>");
				} else if (sAge < <?php echo User::I_USER_YOUNG ?>) {
					openAlert("<?php echo Trad::getTrad(Trad::E_TRAD_WARN_AGE_DOWN, false);?>");
				} else if (sAge > <?php echo User::I_USER_OLD ?>) {
					openAlert("<?php echo Trad::getTrad(Trad::E_TRAD_WARN_AGE_UP, false);?>");
				} else {
					addUser(sName, sAge);
				}
			}
			
			function onKeyPressed(event) {
				var event = event || window.event;
				var target = event.target || event.srcElement;
				
				// enter pressed and not on button (for button, managed by on click)
				if (event.keyCode == 13 && target.nodeName.toLowerCase() != "button") {
					onSubmitClicked();
					return true;
				}
			}
			
			</script>
			<style type="text/css">
			body {
				font-size:x-large;
				text-align:center;
				color: green;
				background-color: #aaaaaa;
				font-family:"Calibri";
			}
			input[type="text"] {
				width:50%;
				display:block;
				margin-bottom:10px;
				background-color:white;
			}
			button {
				width:100%;
				display:block;
			}
			table, tr, th, td {
				border: 1px solid black;
			}
			table, tr {
				width:100%;
			}
			td, th {
				width:50%;
			}
			caption {
				font-size:x-large;
			}
			</style>
		</HEAD>
		<BODY onLoad="setFocus();" onKeyPress="onKeyPressed(event)">
		
		<?php echo Trad::getTrad(Trad::E_TRAD_WELCOME);?>
			
			<table>
				<tr>
					<td align="center"><?php echo Trad::getTrad(Trad::E_TRAD_NAME);?></td>
					<td align="center"><?php echo Trad::getTrad(Trad::E_TRAD_AGE);?></td>
				</tr>
				<tr>
					<td align="center"><input type="text" id="name"/></td>
					<td align="center"><input type="text" id="age"/></td>
				</tr>
			</table>
			<div>
				<!-- button type = button, avoiding onclick called after enter on pressed (submit button IE 'issue')-->
				<button type="button" onclick="onSubmitClicked()"><?php echo Trad::getTrad(Trad::E_TRAD_SUBMIT);?></button>
				<button type="button" onclick="reset()"><?php echo Trad::getTrad(Trad::E_TRAD_RESET);?></button>
			</div>
			<br/>
		<?php UserManager::displayUsers(); ?>
		</BODY> 
	</HTML>
		<?php
	}
?>