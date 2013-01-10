function Schmolck_Gui(strId)
{
	if (arguments.length) {
		this.Init(strId);
	}
}

Schmolck_Gui.prototype.Init = function(strId)
{
	this._strId = strId;
};