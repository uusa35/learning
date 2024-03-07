import React from "react";
import Fullcalendar from "@fullcalendar/react";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import moment from "moment";
import {
    HoverCard,
    HoverCardContent,
    HoverCardTrigger,
} from "@/shadcn/ui/hover-card";
import { Tooltip } from "@/shadcn/ui/tooltip";

const AppointmentCalendar = () => {
    const events = [
        {
            title: "title one",
            description: "description for Click for Google",
            start: moment().format(),
            end: moment().add(2, "hours").format(),
            display: "block",
            backgroundColor: "green",
        },
    ];
    return (
        <div className="mx-4">
            <Fullcalendar
                plugins={[dayGridPlugin, timeGridPlugin, interactionPlugin]}
                initialView={"dayGridMonth"}
                handleWindowResize={true}
                defaultAllDay={false}
                displayEventEnd={true}
                firstDay={6}
                headerToolbar={{
                    start: "today prev,next", // will normally be on the left. if RTL, will be on the right
                    center: "title",
                    end: "dayGridMonth,timeGridWeek,timeGridDay", // will normally be on the right. if RTL, will be on the left
                }}
                eventTimeFormat={{
                    hour: "2-digit",
                    minute: "2-digit",
                }}
                navLinks={true}
                dayMaxEvents={false}
                height={"90vh"}
                events={events}
                eventDidMount={(info: any) => ({
                    el: () => {
                        return (
                            <HoverCard>
                                <HoverCardContent>
                                    {info.event.extendedProps.description}
                                </HoverCardContent>
                            </HoverCard>
                        );
                    },
                })}
            />
        </div>
    );
};

export default AppointmentCalendar;
