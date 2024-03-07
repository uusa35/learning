import SunEditor, { buttonList } from "suneditor-react";
import "suneditor/dist/css/suneditor.min.css"; // Import Sun Editor"s CSS File

type Props = {
    language: string;
    name: string;
    setData: (data: any) => void;
    data: any;
    defaultValue?: string;
};
export function TextEditor({
    setData,
    language,
    name,
    data,
    defaultValue,
}: Props) {
    const handleChange = (e: string) => {
        setData((data: any) => ({
            ...data,
            [`${name}`]: {
                ...data[`${name}`],
                [`${language}`]: e,
            },
        }));
    };

    return (
        <SunEditor
            defaultValue={defaultValue}
            onChange={(e) => handleChange(e)}
            setOptions={{
                height: `200`,
                buttonList: buttonList.complex,
            }}
        />
    );
}
