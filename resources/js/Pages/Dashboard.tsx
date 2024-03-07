import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/types";
import SignatureCanvas from "react-signature-canvas";
import { useState } from "react";
import AppointmentCalendar from "@/components/AppointmentCalender";

export default function Dashboard({ auth }: PageProps) {
    const [signature, setSignature] = useState<SignatureCanvas | null>();
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            You're logged in!
                        </div>{" "}
                        <div className="flex flex-col  w-full  justify-center items-center gap-y-4 mx-4">
                            <h1>Signature</h1>
                            <SignatureCanvas
                                ref={(data) => setSignature(data)}
                                penColor="blue"
                                canvasProps={{
                                    width: 500,
                                    height: 200,
                                    className:
                                        "sigCanvas rounded-lg border border-gray-200 mx-auto my-8",
                                }}
                            />
                        </div>
                        <AppointmentCalendar />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
