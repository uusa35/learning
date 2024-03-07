import { FC, useEffect } from "react";
import { store } from "@/redux/store";
import { Provider } from "react-redux";
import { User } from "@/types/queries";
import { Locale, PageProps } from "@/types/index";

type Props = {
    children: React.ReactNode;
};

const AppProvider: FC<Props> = ({ children }) => {
    return <Provider store={store}>{children}</Provider>;
};

export default AppProvider;
