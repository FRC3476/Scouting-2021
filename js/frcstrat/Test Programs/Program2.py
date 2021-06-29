import time
import numpy as np
import frcstat as frc


frc.resetClient(frc.TBA_Client("VPexr6soymZP0UMtFw2qZ11pLWcaDSxCMUYOfMuRj5CQT3bzoExsUGHuO1JvyCyU"))

ev = frc.Event("2020caln")

f1 = open('2020-LAN.txt', 'w+')

for comp_level in ev.getMatchData():
	print (ev.getMatchData()[comp_level]["alliances"]["red"]["team_keys"][0],", ", ev.getMatchData()[comp_level]["alliances"]["red"]["team_keys"][1],", ", ev.getMatchData()[comp_level]["alliances"]["red"]["team_keys"][2],", ", (ev.getMatchData()[comp_level]["score_breakdown"]["red"]["autoCellsInner"])+(ev.getMatchData()[comp_level]["score_breakdown"]["red"]["teleopCellsInner"]),", ", ev.getMatchData()[comp_level]["alliances"]["blue"]["team_keys"][0],", ", ev.getMatchData()[comp_level]["alliances"]["blue"]["team_keys"][1],", ", ev.getMatchData()[comp_level]["alliances"]["blue"]["team_keys"][2],", ", (ev.getMatchData()[comp_level]["score_breakdown"]["blue"]["autoCellsInner"])+(ev.getMatchData()[comp_level]["score_breakdown"]["blue"]["teleopCellsInner"]),file = f1)

f1.flush()
