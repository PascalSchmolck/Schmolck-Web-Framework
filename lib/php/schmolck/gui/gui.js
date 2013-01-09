function Schmolck_Gui(strId)
{
	if (arguments.length) {
		this.Init(strId);
	}
}

Schmolck_Gui.prototype.Init = function(strId)
{
	this._strId = strId;

	this.AttachFading();
};

Schmolck_Gui.prototype.AttachFading = function()
{
	$("#"+this._strId).fadeTo(2000, 1);
};