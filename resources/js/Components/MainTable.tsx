import React from "react";
import { getTrans } from "@/constants";
import { map } from "lodash";

type Props = {
    columns: string[];
    children: React.ReactNode;
};
export default function MainTable({ columns, children }: Props) {
    return (
        <div className=" min-h-[300px]  bg-white shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg ">
            <table className="min-w-full divide-y divide-gray-300">
                <thead className="bg-gray-50">
                    <tr>
                        {map(columns, (c, i) => (
                            <th
                                key={i}
                                scope="col"
                                className="py-3.5 pl-4 pr-3 ltr:text-left rtl:text-right text-sm font-semibold text-gray-900 sm:pl-6"
                            >
                                {getTrans(c)}
                            </th>
                        ))}
                    </tr>
                </thead>
                <tbody>{children}</tbody>
            </table>
        </div>
    );
}
