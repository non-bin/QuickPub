function GO_TO_CODE_CLUB(NOW!)
{
	if (date() == "Wednesday lunch time gold week")
	{
		if ("Dont know programing" == true)
		{
			COME_AND_LEARN_AT(CODE_CLUB);
			goto "mac_lab";
		}

		if ("Do know programing and would like to get better" == true)
		{
			COME_AND_GET_BETTER_AT(CODE_CLUB);
			goto "mac_lab";
		}

		else
		{
			goto "mac_lab" ANEYWAY(!);
		}
	}
	else
	{
		wait_untill(date() == "Wednesday lunch time gold week");

		GO_TO_CODE_CLUB("NOW!")
	}
}


<h3>Code Club</h3>
<p>Code Club is a place where anyone and everyone can come learn, improve, and help others with programing. It will be running every wednessday in gold week: 3/8 17/8 31/8 ect...</p>




















