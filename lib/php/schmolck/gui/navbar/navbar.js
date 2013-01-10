function Schmolck_Gui_Navbar(strId)
{
	if (arguments.length) {
		this.Init(strId);
	}
}

Schmolck_Gui_Navbar.prototype = new Schmolck_Gui();

Schmolck_Gui_Navbar.prototype.Init = function(strId)
{
	this.parentInit = Schmolck_Gui.prototype.Init;
	this.parentInit(strId);
};