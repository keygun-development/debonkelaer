// This prevents from loading in all fontawesome icons which has an impact for load time
import {library, dom} from '@fortawesome/fontawesome-svg-core';

// import the needed icons here
import {
    faXmark,
    faChevronRight,
    faHouse,
    faNewspaper,
    faTag,
    faBars,
    faList,
    faImage,
    faUser,
    faArrowLeft
} from '@fortawesome/free-solid-svg-icons';

library.add(
    faXmark,
    faChevronRight,
    faHouse,
    faNewspaper,
    faTag,
    faBars,
    faList,
    faImage,
    faUser,
    faArrowLeft
);

dom.watch();
