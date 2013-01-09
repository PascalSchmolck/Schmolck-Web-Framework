function Schmolck_Gui_Box(strId)
{
	if (arguments.length) {
		this.Init(strId);
	}
}

Schmolck_Gui_Box.prototype = new Schmolck_Gui();

Schmolck_Gui_Box.prototype.Init = function(strId)
{
	this.parentInit = Schmolck_Gui.prototype.Init;
	this.parentInit(strId);

	this.AttachClickAction();
};

Schmolck_Gui_Box.prototype.AttachClickAction = function()
{
	var myself = this;
	$("#"+myself._strId).click(function() {
		$("#"+myself._strId).slideUp("fast", function() {
			$("#"+myself._strId).slideDown("slow");
		});

	});
};